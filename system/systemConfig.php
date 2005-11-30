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

class systemConfig {
    public static $pathToApplication;
    public static $pathToSystem;
    public static $pathToTemp;
    public static $pathToConf;

    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__) . '/';
    }
}
?>