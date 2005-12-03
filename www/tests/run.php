<?php

require_once 'init.php';
require_once 'testsFinder.php';

$casesBasedir = 'cases';
$casesDir = $casesBasedir;
$casesName = 'all';

if (isset($_GET['group'])) {
    $group = $_GET['group'];
    $group = preg_replace('/[^a-z]/i', '', $group);
    if (is_dir($casesDir . '/' . $group)) {
        $casesDir .= '/' . $group;
        $casesName = $group;
    }
}

$test = new GroupTest($casesName . ' tests');

foreach (testsFinder::find($casesDir) as $case) {
    $test->addTestFile($case);
}

$test->run(new HtmlReporter('windows-1251'));

echo '<a href="/tests/run.php">all tests</a><br />';
foreach (testsFinder::getDirsList($casesBasedir) as $dirlist) {
    $name = substr(strrchr($dirlist, '/'), 1);
    echo '<a href="/tests/run.php?group=' . $name . '">' . $name . ' tests</a><br />';
}

?>