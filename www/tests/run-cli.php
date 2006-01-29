<?php

//error_reporting(E_ALL | E_STRICT);
error_reporting(E_ALL);

require_once 'init.php';
require_once 'testsFinder.php';


class testsRunner implements iFilter
{
    public function run(filterChain $filter_chain, $response)
    {
        global $argv;
        ob_start();
        $casesBasedir = 'cases';
        $casesDir = $casesBasedir;
        $casesName = 'all';

        echo "Mzz.Cms v" . MZZ_VERSION . " tests.\r\n";

        if (isset($argv[1])) {
            $group = $argv[1];
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


        $test->run(new TextReporter());

        $timerFactory = new timerFactory('view');
        $timer = $timerFactory->getController();

        $result = ob_get_contents();
        ob_end_clean();
        $response->append($result);

        $filter_chain->next();
    }
}


try {
    $response = new response();

    $filter_chain = new filterChain($response);
    $filter_chain->registerFilter(new timingFilter());
    $filter_chain->registerFilter(new testsRunner());
    $filter_chain->process();

    $response->send();


} catch (MzzException $e) {
    $e->printHtml();
} catch (Exception $e) {
    $name = get_class($e);
    $e = new mzzException($e->getMessage(), $e->getCode(), $e->getLine(), $e->getFile());
    $e->setName($name);
    $e->printHtml();
}

?>