<?php

require_once SYSTEM . 'core/resolver/fileResolver.php';
fileResolver::includer('core');
$application = new core();
$application->run();

?>