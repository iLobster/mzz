<?php
/**
 * Define version
 *
 * @todo move it in special place
 */
define('MZZ_VERSION','0.0.1-dev');

require_once SYSTEM . 'resolver/fileResolver.php';
fileResolver::includer('errors', 'error');
fileResolver::includer('template', 'mzzSmarty');
fileResolver::includer('core');

$application = new core();
$application->run();

?>