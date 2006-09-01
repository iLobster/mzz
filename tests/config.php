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

define('SYSTEM_PATH',  realpath(dirname(__FILE__) . '/../system'));

/**
 * Additional adress
 * True: /site1
 * False: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('DEBUG_MODE', 1);
define('TEST_PATH',  realpath(SYSTEM_PATH . '/../tests'));

require_once(SYSTEM_PATH . '/systemConfig.php');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = "mysql:host=localhost;dbname=mzz_test";
systemConfig::$db['default']['user'] = "root";
systemConfig::$db['default']['password'] = "";
systemConfig::$db['default']['charset'] = "cp1251";
systemConfig::$db['default']['pdoOptions'] = array();

systemConfig::$pathToApplication = dirname(__FILE__);
systemConfig::$pathToTemp = systemConfig::$pathToApplication . '/tmp';
systemConfig::$pathToConf = systemConfig::$pathToApplication . '/configs';
systemConfig::init();

// true - ����������, false - ����������� ���������
systemConfig::$cache = true;

?>