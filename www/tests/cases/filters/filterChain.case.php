<?php
fileLoader::load('filters/iFilter');
fileLoader::load('filters/filterChain');
fileLoader::load('cases/filters/stubFilter.class');
fileLoader::load('request/response');

class filterChainTest extends UnitTestCase
{
    private $filterChain;

    function setup()
    {
        $this->filterChain = new filterChain(new response());
    }

    function teardown()
    {
    }

    function testFilters()
    {
        $filter = new stubFilter();
        $filter->setText('f1');
        $this->filterChain->registerFilter($filter);

        $filter = new stubFilter();
        $filter->setText('f2');
        $this->filterChain->registerFilter($filter);

        $filter = new stubFilter();
        $filter->setText('f3');
        $this->filterChain->registerFilter($filter);

        ob_start();
        $this->filterChain->process();
        $response = ob_get_contents();
        ob_end_clean();
        $this->assertEqual($response, "<f1><f2><f3></f3></f2></f1>");
    }
}
?>