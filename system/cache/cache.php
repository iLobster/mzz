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
    //@todo подумать над видом мапы и вынести в конфиг
    protected static $map = array(
        'default' => array(
            'driver' => 'memory'
         )
    );

    protected static $instances = array();

    public static function factory($driver = 'default')
    {
        if (array_key_exists($driver, self::$instances) === false) {
            if (array_key_exists($driver, self::$map) === false) {
                $driver = 'default';
            }

            if (!isset(self::$map[$driver])) {
                throw new mzzRuntimeException('no default cache driver');
            }

            $className = self::$map[$driver]['driver'];
            $params = isset(self::$map[$driver]['params']) ? self::$map[$driver]['params'] : array();
            fileLoader::load('cache/' . $className);
            self::$instances[$driver] = new $className($params);
        }

        return self::$instances[$driver];
    }
}

?>