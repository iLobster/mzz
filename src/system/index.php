<?php

if (!file_exists(systemConfig::$pathToTemp . '/checked') || filemtime(systemConfig::$pathToTemp . '/checked') <= filemtime(systemConfig::$pathToSystem  . '/check.php')) {
    if(file_exists(systemConfig::$pathToTemp . '/checked')) {
        unlink(systemConfig::$pathToTemp . '/checked');
    }
    require(systemConfig::$pathToSystem  . '/check.php');
}

require_once systemConfig::$pathToSystem  . '/version.php';
require_once systemConfig::$pathToSystem  . '/core/core.php';

?>