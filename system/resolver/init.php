<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage resolver
 * @version $Id$
*/

require_once systemConfig::$pathToSystem . '/resolver/iResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/fileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/compositeResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/sysFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/appFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/classFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/moduleResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/configFileResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/libResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/decoratingResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/cachingResolver.php';
require_once systemConfig::$pathToSystem . '/resolver/templateResolver.php';

?>