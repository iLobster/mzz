<?php

function simpletest_error_handler($errno, $errstr, $errfile, $errline) {
    static $count = 0;
    return $count++;
}

require_once 'config.php';
require_once systemConfig::$pathToSystem . 'core/fileloader.php';
require_once systemConfig::$pathToSystem . 'resolver/compositeResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/fileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/sysFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/appFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/classFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/casesFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/testFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/configFileResolver.php';
require_once systemConfig::$pathToSystem . 'resolver/libResolver.php';
$baseresolver = new compositeResolver();
$baseresolver->addResolver(new sysFileResolver());
$baseresolver->addResolver(new testFileResolver());
$baseresolver->addResolver(new appFileResolver());
$resolver = new compositeResolver();
$resolver->addResolver(new classFileResolver($baseresolver));
$resolver->addResolver(new casesFileResolver($baseresolver));
$resolver->addResolver(new libResolver($baseresolver));
$resolver->addResolver(new configFileResolver($baseresolver));
fileLoader::setResolver($resolver);

set_error_handler('simpletest_error_handler');
fileLoader::load('simpletest/unit_tester');
fileLoader::load('simpletest/mock_objects');
fileLoader::load('simpletest/reporter');
restore_error_handler();

fileLoader::load('exceptions/MzzException');
fileLoader::load('exceptions/FileResolverException');
fileLoader::load('exceptions/RegistryException');

?>