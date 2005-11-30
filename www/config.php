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

define('DEBUG_MODE', true);

$_path = dirname(__FILE__);

if(strpos(PHP_OS, 'WIN') !== false) {
    $_path = str_replace('\\', '/', $_path);
}
$_path = substr($_path, 0, strrpos($_path, '/'));

define('ROOT_PATH', $_path);

// System directory (e.g., "c:/mzz/system/" for Windows or "/home/mzz/system/" for Unix).
define('SYSTEM_DIR', ROOT_PATH . '/system/');

// WWW directory (e.g., "c:/mzz/www/" for Windows  or "/home/mzz/www/" for Unix).
define('APPLICATION_DIR', ROOT_PATH . '/www/');

define('CONFIG_DIR', ROOT_PATH . '/www/configs/');

define('TEMP_DIR', ROOT_PATH . '/tmp/');

?>