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
 * @subpackage db
 * @version $Id$
*/

/**
 * DB: класс, обеспечивающий доступ к драйверам баз данных
 *
 * @package system
 * @subpackage db
 * @version 0.2
*/
class DB
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
        if (self::$callback == false) {
            //$toolkit = systemToolkit::getInstance();
            $driverName = systemConfig::$dbDriver;
            $driver = 'mzz' . ucfirst($driverName);
            fileLoader::load('db/drivers/' . $driver);
            self::$callback = array($driver, 'getInstance');
        }

        if (!is_callable(self::$callback)) {
            self::$callback = false;
            throw new mzzCallbackException(self::$callback);
            return false;
        } else {
            return call_user_func(self::$callback);
        }
    }

}
?>