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


        $test->run(new mzzHtmlReporter('windows-1251'));

        echo '<br /><a href="run.php" style="color: black; font: 11px arial, tahoma, verdana;">';
        if(isset($group)) {
            echo 'All tests';
        } else {
            echo '<b>All tests</b>';
        }
        echo '</a>';

        foreach (testsFinder::getCategoriesList($casesDir) as $dirlist) {
            $name = substr(strrchr($dirlist, '/'), 1);
            echo ', <a href="run.php?group=' . $name . '" style="font: 11px arial, tahoma,verdana; ';

            if(isset($group) && $name == $testGroup) {
                 echo 'font-weight: bold; color: #B56104;">' . ucfirst($name) . '</a>';
                 $curDir = $dirlist;
            } else {
                 echo 'color: black;">' . ucfirst($name) . '</a>';
            }
        }

        if(isset($curDir)) {
            $subDirList = '<br /><div style="color: black; font: 11px tahoma,verdana,arial;">- ' . ucfirst($testGroup) . ' tests: ';
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

        echo '<p style="margin-top: 40px; padding-top: 7px; border-top: 1px solid #BBB; font-size: 60%; font-family: Verdana; color: #444; letter-spacing: -1px;" />';
        $action = new action('timer');
        $action->setAction('view');
        $timerFactory = new timerFactory($action);
        $timer = $timerFactory->getController();
        echo $timer->getView();
        echo '. SimpleTest (' . SimpleTest::getVersion() . ') <b>' . simpletest_error_handler(0, 0, 0, 0) . '</b> errors.';
        echo '</p></body></html>';
        $result = ob_get_contents();
        ob_end_clean();
        $response->append($result);

        $filter_chain->next();
    }
}

?>