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
     * The factory method
     *
     * @access public
     * @static
     * @return object
     */
    public static function factory()
    {
        $registry = Registry::instance();
        $config = $registry->getEntry('config');
        $config->load('common');
        $driver = $config->getOption('db', 'driver');
        fileLoader::load('db/drivers/' . $driver);
        $classname = 'mzz' . ucfirst($driver);

        $callback = array($classname, 'getInstance');
        
        if(!is_callable($callback)) {
            //throw new dbException('Driver "' . $driver . '" cann\'t be called.');
            //return false;
            throw new mzzCallbackException($callback);
        } else {
            return call_user_func($callback);
        }
    }

}
?>