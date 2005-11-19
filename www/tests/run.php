<?php

require_once '../config.php';
require_once '../../system/libs/simpletest/unit_tester.php';
require_once '../../system/libs/simpletest/mock_objects.php';
require_once '../../system/libs/simpletest/reporter.php';

require_once 'cases/resolver/fileresolver.case.php';
require_once 'cases/resolver/compositeresolver.case.php';
require_once 'cases/resolver/partialfileresolver.case.php';
require_once 'cases/resolver/sysFileResolver.case.php';
require_once 'cases/resolver/classFileResolver.case.php';
require_once 'cases/resolver/moduleResolver.case.php';
require_once 'cases/resolver/libResolver.case.php';
require_once 'cases/core/fileloader.case.php';
require_once 'cases/request/requestparser.case.php';

$test = new GroupTest('All file tests');
$test->addTestCase(new fileResolverTest());
$test->addTestCase(new compositeResolverTest());
$test->addTestCase(new partialFileResolverTest());
$test->addTestCase(new sysFileResolverTest());
$test->addTestCase(new classFileResolverTest());
$test->addTestCase(new moduleResolverTest());
$test->addTestCase(new libResolverTest());
$test->addTestCase(new fileLoaderTest());
$test->addTestCase(new RequestParserTest());
$test->run(new HtmlReporter('windows-1251'));

/*
$test = new fileResolverTest();
$test->run(new HtmlReporter()); */

?>