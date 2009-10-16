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

define('SYSTEM_PATH',  realpath(dirname(__FILE__) . '/../../system'));

/**
 * Additional adress
 * True: /site1
 * False: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');
define('DEBUG_MODE', 1);

define('MZZ_USER_GUEST_ID', 1);

require_once(SYSTEM_PATH . '/systemConfig.php');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = "mysql:host=localhost;dbname=mzz_test";
systemConfig::$db['default']['user'] = "root";
systemConfig::$db['default']['password'] = "";
systemConfig::$db['default']['charset'] = "utf8";

systemConfig::$db['another']['dsn']  = "mysql:host=localhost;dbname=mzz_test";

systemConfig::$cache['default']['backend'] = 'memory';
systemConfig::$cache['long']['backend'] = 'memory';
systemConfig::$cache['fast']['backend'] = 'memory';
systemConfig::$cache['session']['backend'] = 'memory';

systemConfig::$i18n = 'en';
systemConfig::$i18nEnable = true;

systemConfig::$pathToApplication = realpath($application_path);
systemConfig::$pathToTests = realpath(dirname(__FILE__) . '/..');
systemConfig::$pathToTemp = systemConfig::$pathToTests . '/tmp';
systemConfig::$pathToConf = systemConfig::$pathToTests . '/configs';
systemConfig::init();

?>