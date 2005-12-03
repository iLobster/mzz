<?php

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

fileLoader::load('simpletest/unit_tester');
fileLoader::load('simpletest/mock_objects');
fileLoader::load('simpletest/reporter');

fileLoader::load('exceptions/MzzException');
fileLoader::load('exceptions/FileResolverException');


fileLoader::load('core/registry');

$registry = Registry::instance();
$registry->setEntry('rewrite', 'Rewrite');

?>