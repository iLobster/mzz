<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * Db: класс, обеспечивающий доступ к драйверам баз данных
 *
 * @package system
 * @version 0.2
*/
class Db
{
    /**
     * Callback information
     */
    protected static $callback = false;

    /**
     * The factory method
     *
     * @return object
     */
    public static function factory()
    {
        if(self::$callback == false) {
            $toolkit = systemToolkit::getInstance();
            $config = $toolkit->getConfig();
            $config->load('common');
            $driver = $config->getOption('db', 'driver');
            fileLoader::load('db/drivers/' . $driver);
            $classname = 'mzz' . ucfirst($driver);
            self::$callback = array($classname, 'getInstance');
        }

        if(!is_callable(self::$callback)) {
            self::$callback = false;
            throw new mzzCallbackException(self::$callback);
            return false;
        } else {
            return call_user_func(self::$callback);
        }
    }

}
?>