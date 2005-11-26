<?php

require_once '../config.php';
require_once SYSTEM_DIR . 'libs/simpletest/unit_tester.php';
require_once SYSTEM_DIR . 'libs/simpletest/mock_objects.php';
require_once SYSTEM_DIR . 'libs/simpletest/reporter.php';
require_once SYSTEM_DIR . 'core/fileloader.php';
require_once SYSTEM_DIR . 'resolver/compositeResolver.php';
require_once SYSTEM_DIR . 'resolver/fileResolver.php';
require_once SYSTEM_DIR . 'resolver/sysFileResolver.php';
require_once SYSTEM_DIR . 'resolver/classFileResolver.php';
require_once SYSTEM_DIR . 'resolver/casesFileResolver.php';
require_once SYSTEM_DIR . 'resolver/testFileResolver.php';

$baseresolver = new compositeResolver();
$baseresolver->addResolver(new sysFileResolver());
$baseresolver->addResolver(new testFileResolver());
$resolver = new compositeResolver();
$resolver->addResolver(new classFileResolver($baseresolver));
$resolver->addResolver(new casesFileResolver($baseresolver));
fileLoader::setResolver($resolver);

fileLoader::load('resolver/fileresolver.case');
fileLoader::load('resolver/compositeresolver.case');
fileLoader::load('resolver/partialFileResolver.case');
fileLoader::load('resolver/sysFileResolver.case');
fileLoader::load('resolver/classFileResolver.case');
fileLoader::load('resolver/moduleResolver.case');
fileLoader::load('resolver/libResolver.case');
fileLoader::load('resolver/decoratingResolver.case');
fileLoader::load('resolver/cachingResolver.case');
fileLoader::load('core/fileloader.case');
fileLoader::load('request/requestparser.case');
fileLoader::load('request/rewrite.case');

$test = new GroupTest('All file tests');
$test->addTestCase(new fileResolverTest());
$test->addTestCase(new compositeResolverTest());
$test->addTestCase(new partialFileResolverTest());
$test->addTestCase(new sysFileResolverTest());
$test->addTestCase(new classFileResolverTest());
$test->addTestCase(new moduleResolverTest());
$test->addTestCase(new libResolverTest());
$test->addTestCase(new fileLoaderTest());
$test->addTestCase(new decoratingResolverTest());
$test->addTestCase(new cachingResolverTest());
$test->addTestCase(new RequestParserTest());
$test->addTestCase(new RewriteTest());
$test->run(new HtmlReporter('windows-1251'));

?>