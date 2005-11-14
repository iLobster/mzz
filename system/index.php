<?php
require_once SYSTEM . 'version.php';
require_once SYSTEM . 'resolver/fileResolver.php';

fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core');

$application = new core();
$application->run();

?>