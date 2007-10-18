<?php

/**
 * ���������� ���� �� �����.
 * ���� mzz ���������� � ������ ���-�������, �������� ���� ������
 * ���������: /mzz, /new/site
 * �����������: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');

define('DEBUG_MODE', 1);
define('SYSTEM_PATH', '../system/');

/**
 * ������������� ������ � �� ��� ������������������ �������������
 */
define('MZZ_USER_GUEST_ID', 1);

/**
 * ������������� ������, ��� ������� ACL ������ ����� ���������� true (�.�. ����������� ������ ������)
 */
define('MZZ_ROOT_GID', 2);

require_once(SYSTEM_PATH . 'systemConfig.php');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=mzz';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
systemConfig::$db['default']['charset'] = 'cp1251';
systemConfig::$db['default']['pdoOptions'] = array();

systemConfig::$pathToApplication = dirname(__FILE__) . '';
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/../tmp');
systemConfig::$pathToConf = dirname(__FILE__) . '/configs';

systemConfig::init();

?>