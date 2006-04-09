<?php

if(!file_exists(systemConfig::$pathToTemp . '/checked')) {
    include(systemConfig::$pathToSystem  . '/check.php');
}

require_once systemConfig::$pathToSystem  . '/version.php';
require_once systemConfig::$pathToSystem  . '/core/core.php';

$application = new core();
$application->run();

?>