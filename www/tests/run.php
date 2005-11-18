<?php

require_once '../../system/libs/simpletest/unit_tester.php';
require_once '../../system/libs/simpletest/mock_objects.php';
require_once '../../system/libs/simpletest/reporter.php';

require_once 'cases/resolver/fileresolver.case.php';
require_once 'cases/core/fileloader.case.php';

$test = new GroupTest('All file tests');
$test->addTestCase(new fileResolverTest());
$test->addTestCase(new fileLoaderTest());
$test->run(new HtmlReporter('windows-1251'));

/*
$test = new fileResolverTest();
$test->run(new HtmlReporter()); */

?>