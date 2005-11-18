<?php

require_once '../../system/libs/simpletest/unit_tester.php';
require_once '../../system/libs/simpletest/reporter.php';
require_once '../../system/resolver/fileresolvert.php';
require_once 'cases/resolver/fileresolver.case.php';

$test = new fileResolverTest();
$test->run(new HtmlReporter());

?>