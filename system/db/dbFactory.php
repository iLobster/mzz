<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * DB - класс, обеспечивающий доступ к драйверам баз данных
 *
 * @package system
 * @version 0.1
*/
class DB
{
    /**
     * Singleton
     *
     * @var object
     * @access private
     * @staticvar
     */
    private static $instance;

    /**
     * The factory method
     *
     * @access public
     * @static
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            if (file_exists(SYSTEM . 'db/driver_' . DB_DRIVER . '.php')) {
                include_once(SYSTEM . 'db/driver_' . DB_DRIVER . '.php');
                $classname = 'Mzz' . ucfirst(DB_DRIVER);
                self::$instance = new $classname(DB_HOST, DB_USER, DB_PASSWORD, DB_BASE);
            } else {
                throw new Exception ('Driver "'.DB_DRIVER.'" not found');
            }
        }
        return self::$instance;
   }

}
?>