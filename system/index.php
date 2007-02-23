<?php

if (!file_exists(systemConfig::$pathToTemp . '/checked') || filemtime(systemConfig::$pathToTemp . '/checked') <= filemtime(systemConfig::$pathToSystem  . '/check.php')) {
    include(systemConfig::$pathToSystem  . '/check.php');
}

set_include_path(realpath(systemConfig::$pathToSystem  . '/../libs/PEAR/') . PATH_SEPARATOR . get_include_path());

require_once systemConfig::$pathToSystem  . '/version.php';
require_once systemConfig::$pathToSystem  . '/core/core.php';

?>