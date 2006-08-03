<?php

class testsHtmlRunner implements iFilter
{
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        ob_start();
        $casesBasedir = 'cases';
        $casesDir = TEST_PATH . '/' . $casesBasedir;

        $casesName = 'all';
        $casesDirGroup = $casesDir;

        if (isset($_GET['group'])) {
            $group = $_GET['group'];

            $path = explode('/', $_GET['group']);
            $testGroup = $path[0];
            if(count($path) > 1) {
                $testSubGroup = $path[1];
            }

            if (is_dir($casesDir . '/' . $group)) {
                $casesDirGroup = $casesDirGroup . '/' . $group;
                $casesName = $group;
            }
        }

        $test = new GroupTest($casesName . ' tests');

        foreach (testsFinder::find($casesDirGroup) as $case) {
            $test->addTestFile($case);
        }

        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';

        $test->run(new HtmlReporter('windows-1251'));

        echo '<br /><a href="run.php"  style="color: black; font: 11px arial,verdana,tahoma;">';
        if(isset($group)) {
            echo 'All tests';
        } else {
            echo '<b>All tests</b>';
        }
        echo '</a>';

        foreach (testsFinder::getCategoriesList($casesDir) as $dirlist) {
            $name = substr(strrchr($dirlist, '/'), 1);
            echo ' - <a href="run.php?group=' . $name . '" style="color: black; font: 11px tahoma,verdana,arial;">';

            if(isset($group) && $name == $testGroup) {
                 echo '<b>' . ucfirst($name) . ' tests</b></a>';
                 $curDir = $dirlist;
            } else {
                 echo ucfirst($name) . ' tests</a>';
            }
        }
        echo "<br />";
        if(isset($curDir)) {
            $subDirList = '<br /><div style="color: black; font: 12px tahoma,verdana,arial;">' . ucfirst($testGroup) . ' tests &gt;&gt;&gt; ';
            foreach(testsFinder::getDirsList($curDir) as $subDir) {
                $subTest = explode('cases', $subDir);
                $subTestDir = substr($subTest[1],1);
                $subTestName = substr(strrchr($subTestDir, '/'), 1);

                if($group == $subTestDir) {
                    $subDirList .= '<a href="run.php?group=' . $subTestDir . '" style="color: black; font: 11px tahoma,verdana,arial;"><b>' . ucfirst($subTestName) . '</b></a> - ';
                } else {
                    $subDirList .= '<a href="run.php?group=' . $subTestDir . '" style="color: black; font: 11px tahoma,verdana,arial;">' . ucfirst($subTestName) . '</a> - ';
                }
                $isSubDir = true;
            }
            if(isset($isSubDir)) echo '' . substr($subDirList, 0 , -2) . '</div>';

        }


        echo '<br /><font style="color: black; font: 11px tahoma,verdana,arial;">SimpleTest (' . SimpleTest::getVersion() . ') error counter: ' . simpletest_error_handler(0, 0, 0, 0) . '</font>';

        $action = new action('timer');
        $action->setAction('view');
        $timerFactory = new timerFactory($action);
        $timer = $timerFactory->getController();
        echo $timer->getView()->toString();

        echo '</body></html>';
        $result = ob_get_contents();
        ob_end_clean();
        $response->append($result);

        $filter_chain->next();
    }
}

?>