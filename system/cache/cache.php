<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage cache
 * @version $Id$
 */

require_once systemConfig::$pathToSystem . '/exceptions/mzzException.php';
require_once systemConfig::$pathToSystem . '/cache/cacheBackend.php';

/**
 * cache: класс для работы с кэшем
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1
 */
class cache
{
    const DEFAULT_CONFIG_NAME = 'default';

    /**
     * Cache backends instances
     *
     * @var array
     */
    protected static $instances = array();

    /**
     * @var cacheBackend
     */
    protected $backend;

    protected $type;

    /**
     * Фабрика для получения объекта кэширования
     *
     * @param string $configName the name of the cache backend configuration (it is also the instance name)
     * @param array $configs configurations (if passed as null, the system configurations will be used)
     * @return iCache
     */
    public static function factory($configName = self::DEFAULT_CONFIG_NAME, $configs = null)
    {
        $configs = empty($configs) ? systemConfig::$cache : $configs;

        if ($configName == self::DEFAULT_CONFIG_NAME && !isset($configs[self::DEFAULT_CONFIG_NAME])) {
            throw new mzzRuntimeException('no default cache configuration name');
        }

        if (!isset($configs[$configName])) {
            throw new mzzUnknownCacheConfigException($configName);
        }

        $config = $configs[$configName];
        if (!isset(self::$instances[$configName])) {
            $className = self::getBackendClassName($config['backend']);
            $params = isset($config['params']) ? $config['params'] : array();
            try {
                $notFound = false;
                if (!class_exists($className)) {
                    fileLoader::load('cache/' . $className);
                    $notFound = !class_exists($className);
                }
            } catch (mzzIoException $e) {
                $notFound = true;
            }
            if ($notFound || empty($config['backend'])) {
                throw new mzzUnknownCacheBackendException($className);
            }
            self::$instances[$configName] = new cache(new $className($params), $configName);
        }

        return self::$instances[$configName];
    }

    public function __construct(cacheBackend $backend, $type)
    {
        $this->backend = $backend;
        $this->type = $type;
    }

    public function set($key, $val, array $tags = array(), $expire = null)
    {
        $data = $this->setTags($val, $tags);
        return $this->backend->set($this->key($key), $data, $expire);
    }

    public function get($key, & $result = null)
    {
        $data = $this->backend->get($this->key($key));

        if (is_array($data) && isset($data['data'])) {
            $this->checkTags($data);

            $result = $data['data'];
        } else {
            $result = null;
        }

        return !is_null($result);
    }

    public function delete($key)
    {
        return $this->backend->delete($this->key($key));
    }

    public function flush()
    {
        $this->backend->flush();
    }

    protected function setTags($value, $tags)
    {
        $data = array(
            'data' => $value,
            'tags' => array());

        if (sizeof($tags)) {
            foreach ($tags as $tag) {
                $rev = $this->getTag($tag);

                if (is_null($rev)) {
                    $rev = $this->clear($tag);
                }

                $data['tags'][$tag] = (int)$rev;
            }
        }

        return $data;
    }

    protected function checkTags(& $data)
    {
        if (isset($data['tags']) && is_array($data['tags'])) {
            foreach ($data['tags'] as $tag => $rev) {
                if ($rev != $this->getTag($tag)) {
                    $data['data'] = null;
                    break;
                }
            }
        }
    }

    protected function getTag($tag)
    {
        return (int)$this->backend->get('tag_' . $tag);
    }

    public function clear($tag)
    {
        $tag_key = 'tag_' . $tag;

        $this->backend->increment($tag_key);
    }

    public function backend()
    {
    	return $this->backend;
    }

    private function key($key)
    {
        return systemConfig::$appName . '_' . systemConfig::$appVersion . '_' . MZZ_VERSION . (systemConfig::$i18nEnable ? systemToolkit::getInstance()->getLang()  : '')  . '_' . $this->type . '_' . $key;
    }

    public static function getBackendClassName($backend)
    {
        return 'cache' . ucfirst($backend);
    }
}

?>