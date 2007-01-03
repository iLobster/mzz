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
/**
 * �������� ������ � ��� ������ MZZ CMS
 *
 * @package system
 */
class mzz {
    /**
     * Name
     *
     */
    const NAME = 'Mzz.Cms';

    /**
     * Major version
     *
     */
    const VERSION_MAJOR = 0;

    /**
     * Minor version
     *
     */
    const VERSION_MINOR = 0;

    /**
     * Micro version
     *
     */
    const VERSION_MICRO = 7;

    /**
     * Status
     *
     */
    const STATUS = '-dev';

    /**
     * Revision
     *
     */
    const REV = '$Rev$';

    /**
     * Url
     *
     */
    const URL = 'http://www.mzz.ru';

    /**
     * Version separator
     *
     */
    const SEP = '.';

    /**
     * ���������� ������� ������
     *
     * @return string
     */
    public static function getVersion() {
        return self::VERSION_MAJOR . self::SEP . self::VERSION_MINOR . self::SEP . self::VERSION_MICRO . self::STATUS;
    }

    /**
     * ���������� �������
     *
     * @return integer
     */
    public static function getRevision() {
        return (int)(substr(self::REV, 6, strrpos(self::REV, ' ') - strpos(self::REV, ' ') - 1));
    }
}
// Name
define('MZZ_NAME',  'Mzz.Cms' );

// Major version
define('MZZ_VERSION_MAJOR', 0 );

// Minor version
define('MZZ_VERSION_MINOR', 0 );

// Micro version
define('MZZ_VERSION_MICRO', 7 );

// Status
define('MZZ_VERSION_STATUS', '-dev' );

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
    define('MZZ_VERSION_REVISION', $revision);
} else {
    define('MZZ_VERSION_REVISION', 'release');
}

// Url
define('MZZ_URL', 'http://www.mzz.ru');

?>