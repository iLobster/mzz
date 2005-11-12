<?php
define('_START_TIME', microtime(true));
error_reporting(E_ALL);
require_once './config.php';
require_once SYSTEM . 'index.php';

echo "<br><hr size=1><font size=-2>Time: ".(microtime(true)-_START_TIME);
?>
