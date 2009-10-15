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

fileLoader::load('cache/cacheBackend');

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
    private $backend;

    private $expire = 60;

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
            $className = 'cache' . ucfirst($config['backend']);
            $params = isset($config['params']) ? $config['params'] : array();
            try {
                fileLoader::load('cache/' . $className);
                $notFound = !class_exists($className);
            } catch (mzzIoException $e) {
                $notFound = true;
            }
            if ($notFound || empty($config['backend'])) {
                throw new mzzUnknownCacheBackendException($className);
            }
            self::$instances[$configName] = new cache(new $className($params));
        }

        return self::$instances[$configName];
    }

    public function __construct(cacheBackend $backend)
    {
        $this->backend = $backend;
    }

    public function set($key, $val, array $tags = array(), $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->expire;
        }

        $data = $this->setTags($val, $tags);
        return $this->backend->set($key, $data, $expire);
    }

    public function get($key)
    {
        $data = $this->backend->get($key);

        if (is_array($data) && isset($data['data'])) {
            $this->checkTags($data, $key);

            return $data['data'];
        }
    }

    public function delete($key)
    {
        return $this->backend->delete($key);
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

    protected function checkTags(& $data, $key)
    {
        if (isset($data['tags']) && is_array($data['tags'])) {
            foreach ($data['tags'] as $tag => $rev) {
                if ($rev != $this->getTag($tag)) {
                    $data['data'] = false;
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

}

?>