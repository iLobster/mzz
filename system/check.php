<?php

$success = true;

$failed = "<font color='red'><b>failed</b></font>";

define('REQUIRED_PHP_VERSION', '5.1.2');

if(!version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, ">=")) {
    echo "PHP Version: <b>" . PHP_VERSION . "</b>, required >= " . REQUIRED_PHP_VERSION . ", result: " . $failed . "<br>";
    $success = false;
}

if(!class_exists('pdo')) {
    echo "PDO exists: " . $failed . "<br>";
    $success = false;
}

if(!class_exists('pdo') || !in_array('mysql', PDO::getAvailableDrivers())) {
    echo "PDO_MYSQL exists: " . $failed . "<br>";
    $success = false;
}

if(!class_exists('pdo') || !in_array('mysql', PDO::getAvailableDrivers()) || !(PDO::ATTR_SERVER_VERSION >= 4)) {
    echo "PDO_MYSQL Version: <b>" . PDO::ATTR_SERVER_VERSION ."</b>, required >= 4, result: " . $failed . "<br>";
    $success = false;
}

if(!function_exists('simplexml_load_file')) {
    echo "SimpleXML exists: " . $failed . "<br>";
    $success = false;
}

if(!function_exists('preg_match') || !function_exists('preg_replace')) {
    echo "PCRE exists: " . $failed . "<br>";
    $success = false;
}
if($success) {
    file_put_contents(systemConfig::$pathToTemp . '/checked', 'превед!');
} else {
    exit('** Break');
}

?>