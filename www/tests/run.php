<?php

require_once 'run.php';
require_once 'testsFinder.php';

$test = new GroupTest("All tests");

foreach (testsFinder::find('cases') as $case) {
    //echo $case.'<br>';
    $test->addTestFile($case);
}

?>