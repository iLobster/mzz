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
        FileLoader::load('db/drivers/' . $driver);
        $classname = 'Mzz' . ucfirst($driver);

        try {
            if(!is_callable(array($classname, 'getInstance'))) {
                throw new DbException('Driver "' . $driver . '" cann\'t be called.');
                return false;
            } else {
                return call_user_func(array($classname, 'getInstance'));
            }
        } catch (DbException $e) {
            $e->printHtml();
        }
    }

}
?>