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
 * DB: �����, �������������� ������ � ��������� ��� ������
 *
 * @package system
 * @version 0.2
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
    public static function factory()
    {
        $config = configFactory::getInstance();
        $config->load('common');
        $driver = $config->getOption('db','driver');
        fileLoader::load('db/driver_' . $driver);
        $classname = 'Mzz' . ucfirst($driver);
        return call_user_func(array($classname, 'getInstance'));
        // } else {
        //     throw new Exception ('Driver "'.$driver.'" not found');
        // }
    }

}
?>