<?php
require_once SYSTEM_DIR . 'version.php';
require_once SYSTEM_DIR . 'resolver/fileResolver.php';

fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core');

$application = new core();
$application->run();

?>