<?php

$errors = array();

$failed = "<font color='red'><b>failed</b></font>";

define('REQUIRED_PHP_VERSION', '5.1.4');

if (!version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, ">=")) {
    $errors[] = "PHP Version: <b>" . PHP_VERSION . "</b>, required >= " . REQUIRED_PHP_VERSION . ", result: " . $failed;
}

// pdo check
$pdoExists = class_exists('pdo');

if (!$pdoExists) {
    $errors[] = "<i>php_pdo</i> enabled: " . $failed;
}

if (!$pdoExists || ($pdoExists && !in_array('mysql', PDO::getAvailableDrivers()))) {
    $errors[] = "<i>php_pdo_mysql</i> enabled: " . $failed;
}


if (!$pdoExists || ($pdoExists && !in_array('mysql', PDO::getAvailableDrivers()) && PDO::ATTR_SERVER_VERSION < 4 )) {
    $pdoVersion = $pdoExists ? PDO::ATTR_SERVER_VERSION : 'unknown';
    $errors[] = "<i>php_pdo_mysql</i> version: <b>" . $pdoVersion  ."</b>, required >= 4, result: " . $failed;
}
// end pdo check

if (!extension_loaded('pcre')) {
    $errors[] = "PCRE enabled: " . $failed;
}

if (!extension_loaded('gd')) {
    $errors[] = "GD2 enabled: " . $failed;
}

if (extension_loaded('gd') && !function_exists('imagecreatetruecolor')) {
    $errors[] = "GD version 2.0.1 or later: " . $failed;
}

if (!is_readable(systemConfig::$pathToTemp)) {
    $errors[] = 'Directory "' . systemConfig::$pathToTemp . '" <font color="red"><b>is not readable</b></font>';
}

if (!is_readable(systemConfig::$pathToTemp . '/templates_c')) {
    $errors[] = 'Directory "' . systemConfig::$pathToTemp . '/templates_c" <font color="red"><b>is not readable</b></font>';
}

if (!is_writable(systemConfig::$pathToTemp)) {
    $errors[] = 'Directory "' . systemConfig::$pathToTemp . '" <font color="red"><b>is not writable</b></font>';
}

if (!is_writable(systemConfig::$pathToTemp . '/templates_c')) {
    $errors[] = 'Directory "' . systemConfig::$pathToTemp . '/templates_c" <font color="red"><b>is not writable</b></font>';
}


if (empty($errors)) {
    file_put_contents(systemConfig::$pathToTemp . '/checked', 'превед!');
} else {
    exit('<span style="font-size: 120%; font-weight: bold;">mzz не может быть запущен по причине:</span><br />' . implode('<br />', $errors));
}

?>