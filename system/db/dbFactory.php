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
        $config = configFactory::getInstance();
        $config->load('common');
        $driver = $config->getOption('db','driver');
        if (file_exists(SYSTEM . 'db/driver_' . $driver . '.php')) {
            include_once(SYSTEM . 'db/driver_' . $driver . '.php');
            $classname = 'Mzz' . ucfirst($driver);
            return call_user_func(array($classname, 'getInstance'));
        } else {
            throw new Exception ('Driver "'.$driver.'" not found');
        }
   }

}
?>