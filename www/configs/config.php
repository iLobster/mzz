<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * Абсолютный путь до сайта.
 * Если mzz установлен в корень веб-сервера, оставьте поле пустым
 * Правильно: /mzz, /new/site
 * Неправильно: site1, site1/, /site1/
 *
 */
define('SITE_PATH', '');
define('COOKIE_DOMAIN', '');

define('DEBUG_MODE', 1);
define('SYSTEM_PATH', realpath(dirname(__FILE__) . '/../../system/'));

/**
 * Идентификатор записи в БД для неавторизированных пользователей
 */
define('MZZ_USER_GUEST_ID', 1);

/**
 * Идентификатор группы, для которой ACL всегда будет возвращать true (т.е. предоставит полный доступ)
 */
define('MZZ_ROOT_GID', 3);

require_once SYSTEM_PATH . DIRECTORY_SEPARATOR . 'systemConfig.php';

// дефолтный язык приложения
systemConfig::$i18n = 'ru';

// включаем мультиязычность
systemConfig::$i18nEnable = true;

// устанавливаем дефолтную кодировку для выдачи
ini_set('default_charset', 'utf-8');

systemConfig::$db['default']['driver'] = 'pdo';
systemConfig::$db['default']['dsn']  = 'mysql:host=localhost;dbname=mzz';
systemConfig::$db['default']['user'] = 'root';
systemConfig::$db['default']['password'] = '';
systemConfig::$db['default']['charset'] = 'utf8';
systemConfig::$db['default']['options'] = array();

systemConfig::$pathToApplication = dirname(__FILE__) . '/..';
systemConfig::$pathToTemp = realpath(dirname(__FILE__) . '/../../tmp');
systemConfig::$pathToConf = dirname(__FILE__);

systemConfig::$mailer['default']['backend'] = 'PHPMailer';
systemConfig::$mailer['default']['params'] = array('html' => true, 'smtp' => true, 'smtp_host' => 'localhost');

systemConfig::$cache['default']['backend'] = 'memory';
systemConfig::$cache['memory']['backend'] = 'memory';
//systemConfig::$cache['default']['params'] = array('path' => systemConfig::$pathToTemp . DIRECTORY_SEPARATOR . 'cache', 'prefix' => 'cf2_');

systemConfig::$cache['insession']['backend'] = 'session';
systemConfig::$cache['insession']['params'] = array('session_key' => 'cache__');

/*
systemConfig::$cache['memcached']['backend'] = 'memcached';
systemConfig::$cache['memcached']['params'] = array('servers' => array('localhost' => array()));
*/

systemConfig::init();

?>
