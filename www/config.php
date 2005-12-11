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

define('SYSTEM_PATH',  '../system/');
define('DEBUG_MODE', 1);
require_once(SYSTEM_PATH . 'systemConfig.php');

systemConfig::$pathToApplication = dirname(__FILE__) . '/';
systemConfig::$pathToTemp = dirname(__FILE__) . '/../tmp/';
systemConfig::$pathToConf = dirname(__FILE__) . '/configs/';
systemConfig::init();

// в будущем перенести надо куда нить?
$inc_path = ini_get('include_path') . PATH_SEPARATOR . systemConfig::$pathToSystem  . 'libs/PEAR/';
ini_set('include_path', $inc_path);


?>
