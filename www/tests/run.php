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

echo '<br /><a href="/tests/run.php"  style="color: black; font: 11px arial,verdana,tahoma;">';
if(isset($group)) {
    echo 'All tests';
} else {
    echo '<b>All tests</b>';
}
echo '</a>';

foreach (testsFinder::getDirsList($casesBasedir) as $dirlist) {
    $name = substr(strrchr($dirlist, '/'), 1);
    echo ' - <a href="/tests/run.php?group=' . $name . '" style="color: black; font: 11px tahoma,verdana,arial;">';
    if(isset($group) && $name == $group) {
        echo '<b>' . ucfirst($name) . ' tests</b>';
    } else {
        echo ucfirst($name) . ' tests';
    }
    echo '</a>';
}

?>