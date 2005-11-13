<?php

require_once SYSTEM . 'resolver/fileResolver.php';
fileResolver::includer('errors', 'error');
fileResolver::includer('core');
$application = new core();
$application->run();

?>