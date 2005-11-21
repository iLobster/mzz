<?php
require_once SYSTEM_DIR . 'version.php';
//require_once SYSTEM_DIR . 'resolver/fileResolver.php';

//require_once SYSTEM_DIR . 'errors/error.php';
//require_once SYSTEM_DIR . 'template/mzzSmarty.php';
require_once SYSTEM_DIR . 'core/core.php';

$application = new core();
$application->run();

?>