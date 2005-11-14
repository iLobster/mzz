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
/**
 * Содержит версию и имя релиза MZZ CMS
 */

// Name
define('MZZ_NAME',  'Mzz.Cms' );

// Major version
define('MZZ_VERSION_MAJOR', 0 );

// Minor version
define('MZZ_VERSION_MINOR', 0 );

// Micro version
define('MZZ_VERSION_MICRO', 1 );

// Status
define('MZZ_VERSION_STATUS', '-dev' );

// Full version
define('MZZ_VERSION', MZZ_VERSION_MAJOR . '.' . MZZ_VERSION_MINOR . '.' .
                      MZZ_VERSION_MICRO . MZZ_VERSION_STATUS);

// Revision
define('MZZ_REVISION', '$Rev$');

// Revision number
define('MZZ_VERSION_REVISION',  (int)(substr(MZZ_REVISION, 6, strrpos(MZZ_REVISION, ' ') - strpos(MZZ_REVISION, ' ') - 1)));

// Url
define('MZZ_URL', 'http://www.mzz.ru');

?>