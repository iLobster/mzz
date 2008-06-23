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
    /**
     * Массив фронтендов кэширования
     *
     * @var array
     */
    protected static $instances = array();

    /**
     * Фабрика для получения объекта кэширования
     *
     * @param string $driver алиас драйвера для кэширования
     * @return object
     */
    public static function factory($driver = 'default')
    {
        $map = systemConfig::$cache;
        if (!isset($map['default'])) {
            throw new mzzRuntimeException('no default cache driver');
        }

        if (array_key_exists($driver, $map) === false) {
            $driver = 'default';
        }

        if (array_key_exists($driver, self::$instances) === false) {
            $className = 'cache' . ucfirst($map[$driver]['driver']);
            $params = isset($map[$driver]['params']) ? $map[$driver]['params'] : null;
            fileLoader::load('cache/' . $className);
            self::$instances[$driver] = new $className($params);
        }

        return self::$instances[$driver];
    }
}

?>