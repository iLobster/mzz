<?php

require_once '../../system/libs/simpletest/unit_tester.php';
require_once '../../system/libs/simpletest/reporter.php';
require_once('../../system/libs/simpletest/mock_objects.php');
require_once '../../system/resolver/fileresolvert.php';
require_once '../../system/request/requestparser.php';

require_once 'cases/resolver/fileresolver.case.php';
require_once 'cases/request/requestparser.case.php';
require_once 'http_request.php';

Mock::generate('httprequest');
$test = new fileResolverTest();
$test->run(new HtmlReporter());
$test2 = new RequestParserTest();
$test2->run(new HtmlReporter());

?>