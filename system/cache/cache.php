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
            self::$instances[$configName] = new $className($params);
        }

        return self::$instances[$configName];
    }
}

?>
