<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/* Configuration file */

// $_path = $_SERVER["DOCUMENT_ROOT"];
$_path = dirname(__FILE__);

if(strpos(PHP_OS,"WIN") !== false && strpos($_path,"\\") !== false) {
    $_path = str_replace('\\', '/', $_path);
}
$_path = substr($_path, 0, strrpos($_path,'/'));

// System directory (e.g., "c:/mzz/system/" for Windows or "/home/mzz/system/" for Unix).
define('SYSTEM', $_path.'/system/');

// WWW directory (e.g., "c:/mzz/www/" for Windows  or "/home/mzz/www/" for Unix).
define('APPLICATION', $_path.'/www/');

define('DB_DRIVER','mysqli');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_BASE','mzz');

?>