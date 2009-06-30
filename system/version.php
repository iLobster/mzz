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

// Name
define('MZZ_NAME',  'Mzz.Framework' );

// Major version
define('MZZ_VERSION_MAJOR', 0);

// Minor version
define('MZZ_VERSION_MINOR', 3);

// Micro version
define('MZZ_VERSION_MICRO', 0);

// Status
define('MZZ_VERSION_STATUS', '-rc1');

// Full version
define('MZZ_VERSION', MZZ_VERSION_MAJOR . '.' . MZZ_VERSION_MINOR . '.' .
                      MZZ_VERSION_MICRO . MZZ_VERSION_STATUS);

// Revision
if(DEBUG_MODE && file_exists(systemConfig::$pathToSystem . '/../.svn/entries')) {
    $svn_entries = file_get_contents(systemConfig::$pathToSystem . '/../.svn/entries');
    if (strpos($svn_entries, '<?xml') !== false) {
        preg_match('/revision="(\d+)"/', $svn_entries, $matches);
        $revision = $matches[1];
    } else {
        $svn_entries = explode("\x0a", $svn_entries, 5);
        $revision = trim($svn_entries[3]);
    }
    define('MZZ_REVISION', $revision);
} else {
    define('MZZ_REVISION', 'release');
}

// Url
define('MZZ_URL', 'http://www.mzz.ru');

?>