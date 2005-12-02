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
/* Configuration file */


define('DEBUG_MODE', 1);


define('SYSTEM_PATH',  '../../system/');

require_once(SYSTEM_PATH . 'systemConfig.php');

systemConfig::$pathToApplication = dirname(__FILE__) . '/';
systemConfig::$pathToTemp = systemConfig::$pathToApplication . 'tmp/';
systemConfig::$pathToConf = systemConfig::$pathToApplication . 'configs/';
systemConfig::init();
?>
