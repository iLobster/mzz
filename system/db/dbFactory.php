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
     * The factory method
     *
     * @access public
     * @static
     * @return object
     */
    public static function getInstance()
    {
        if (file_exists(SYSTEM . 'db/driver_' . DB_DRIVER . '.php')) {
            include_once(SYSTEM . 'db/driver_' . DB_DRIVER . '.php');
            $classname = 'Mzz' . ucfirst(DB_DRIVER);
            return call_user_func(array($classname, 'getInstance'));
        } else {
            throw new Exception ('Driver "'.DB_DRIVER.'" not found');
        }
   }

}
?>