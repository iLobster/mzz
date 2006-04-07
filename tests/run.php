<?php

//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL);

require_once 'init.php';
require_once 'testsFinder.php';


class testsRunner implements iFilter
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
            $group = preg_replace('/[^a-z]/i', '', $group);
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

        foreach (testsFinder::getDirsList($casesDir) as $dirlist) {
            $name = substr(strrchr($dirlist, '/'), 1);
            echo ' - <a href="run.php?group=' . $name . '" style="color: black; font: 11px tahoma,verdana,arial;">';
            if(isset($group) && $name == $group) {
                echo '<b>' . ucfirst($name) . ' tests</b>';
            } else {
                echo ucfirst($name) . ' tests';
            }
            echo '</a>';
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


try {

    $toolkit = systemToolkit::getInstance();
    $request = $toolkit->getRequest();
    $response = $toolkit->getResponse();

    $filter_chain = new filterChain($response, $request);
    $filter_chain->registerFilter(new timingFilter());
    $filter_chain->registerFilter(new testsRunner());
    $filter_chain->process();

    $response->send();

    //$a = new testsRunner();
    //$a->run();


} catch (MzzException $e) {
    $e->printHtml();
} catch (Exception $e) {
    $name = get_class($e);
    $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
    $e->setName($name);
    $e->printHtml();
}

?>