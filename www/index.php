<?php

error_reporting(E_ALL);

require_once './config.php';
require_once systemConfig::$pathToSystem . '/index.php';
require_once './application.php';

$application = new applicaion();
$application->run();

?>
