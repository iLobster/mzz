<?php

//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL);

require_once 'init.php';
require_once 'testsFinder.php';


class testsRunner implements iFilter
{
    public function run(filterChain $filter_chain, $response)
    {
        ob_start();
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

        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';

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
        echo '<br /><font style="color: black; font: 11px tahoma,verdana,arial;">SimpleTest Error counter: ' . simpletest_error_handler(0, 0, 0, 0) . '</font>';
        echo '</body></html>';
        $result = ob_get_contents();
        ob_end_clean();
        $response->append($result);

        $filter_chain->next();
    }
}


try {
    $smarty = new mzzSmarty();
    $smarty->template_dir  = '../templates';
    $smarty->compile_dir   = systemConfig::$pathToTemp . 'templates_c';
    $smarty->plugins_dir[] = systemConfig::$pathToSystem . 'template/plugins';
    $smarty->debugging = DEBUG_MODE;

    $registry = Registry::instance();
    $registry->setEntry('smarty', $smarty);


    $response = new response();

    $filter_chain = new filterChain($response);
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
    $e = new mzzException($e->getMessage(), $e->getCode());
    $e->setName($name);
    $e->printHtml();
}

?>