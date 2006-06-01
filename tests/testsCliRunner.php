<?php

class testsCliRunner implements iFilter
{
    public function run(filterChain $filter_chain, $response, iRequest $request)
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


        $result = ob_get_contents();
        ob_end_clean();
        $response->append($result);

        $filter_chain->next();
    }
}

?>