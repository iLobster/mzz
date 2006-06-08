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

/**
 * Additional adress
 * True: /site1
 * False: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');

define('DEBUG_MODE', 1);

require_once(SYSTEM_PATH . 'systemConfig.php');

systemConfig::$dbDriver = "pdo";
systemConfig::$dbDsn  = "mysql:host=localhost;dbname=mzz";
systemConfig::$dbUser = "root";
systemConfig::$dbPassword = "";
systemConfig::$dbCharset = "cp1251";

systemConfig::$pathToApplication = dirname(__FILE__) . '';
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/../tmp');
systemConfig::$pathToConf = dirname(__FILE__) . '/configs';
systemConfig::$pdoOptions = array();
systemConfig::init();

// в будущем перенести надо куда нить?
$inc_path = ini_get('include_path') . PATH_SEPARATOR . realpath(systemConfig::$pathToSystem  . '/../libs/PEAR/');
ini_set('include_path', $inc_path);


?>
