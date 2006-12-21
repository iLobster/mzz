<?php

define('SYSTEM_PATH',  '../system/');

/**
 * Additional adress
 * True: /site1
 * False: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('DEBUG_MODE', 1);

/**
 * ������������� ������ � �� ��� ������������������ �������������
 *
 */
define('MZZ_USER_GUEST_ID', 1);


require_once(SYSTEM_PATH . 'systemConfig.php');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = "mysql:host=localhost;dbname=mzz";
systemConfig::$db['default']['user'] = "root";
systemConfig::$db['default']['password'] = "";
systemConfig::$db['default']['charset'] = "cp1251";
systemConfig::$db['default']['pdoOptions'] = array();

systemConfig::$pathToApplication = dirname(__FILE__) . '';
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/../tmp');
systemConfig::$pathToConf = dirname(__FILE__) . '/configs';

systemConfig::init();

// @todo �������� � �������� � ������ �����
$inc_path = realpath(systemConfig::$pathToSystem  . '/../libs/PEAR/') . PATH_SEPARATOR . ini_get('include_path');
ini_set('include_path', $inc_path);

?>