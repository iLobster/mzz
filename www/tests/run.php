<?php

require_once 'init.php';
require_once 'testsFinder.php';

$test = new GroupTest("All tests");

foreach (testsFinder::find('cases/request') as $case) {
    echo $case.'<br>';
    $test->addTestFile($case);
}
$test->run(new HtmlReporter('windows-1251'));

?>