<?php

require_once systemConfig::$pathToSystem  . 'version.php';
require_once systemConfig::$pathToSystem  . 'core/Core.php';

$application = new Core();
$application->run();

?>