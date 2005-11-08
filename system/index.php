<?php

require_once SYSTEM . 'resolver/fileResolver.php';
fileResolver::includer('core');
$application = new core();
$application->run();

?>