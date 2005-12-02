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


fileLoader::load('resolver/fileresolver.case');
fileLoader::load('resolver/compositeresolver.case');
fileLoader::load('resolver/partialFileResolver.case');
fileLoader::load('resolver/sysFileResolver.case');
fileLoader::load('resolver/appFileResolver.case');
fileLoader::load('resolver/configFileResolver.case');
fileLoader::load('resolver/classFileResolver.case');
fileLoader::load('resolver/moduleResolver.case');
fileLoader::load('resolver/libResolver.case');
fileLoader::load('resolver/decoratingResolver.case');
fileLoader::load('resolver/cachingResolver.case');
fileLoader::load('resolver/casesFileResolver.case');
fileLoader::load('resolver/testFileResolver.case');
fileLoader::load('config/config.case');
fileLoader::load('core/fileloader.case');
fileLoader::load('core/registry.case');
fileLoader::load('core/sectionMapper.case');
fileLoader::load('request/requestparser.case');
fileLoader::load('request/rewrite.case');

$registry = Registry::instance();
$registry->setEntry('rewrite', 'Rewrite');

$test = new GroupTest('All file tests');
$test->addTestCase(new fileResolverTest());
$test->addTestCase(new registryTest());
$test->addTestCase(new configTest());
$test->addTestCase(new compositeResolverTest());
$test->addTestCase(new partialFileResolverTest());
$test->addTestCase(new sysFileResolverTest());
$test->addTestCase(new appFileResolverTest());
$test->addTestCase(new configFileResolverTest());
$test->addTestCase(new classFileResolverTest());
$test->addTestCase(new moduleResolverTest());
$test->addTestCase(new libResolverTest());
$test->addTestCase(new fileLoaderTest());
$test->addTestCase(new decoratingResolverTest());
$test->addTestCase(new cachingResolverTest());
$test->addTestCase(new casesFileResolverTest());
$test->addTestCase(new testFileResolverTest());
$test->addTestCase(new RequestParserTest());
$test->addTestCase(new RewriteTest());
$test->addTestCase(new sectionMapperTest());
$test->run(new HtmlReporter('windows-1251'));

?>