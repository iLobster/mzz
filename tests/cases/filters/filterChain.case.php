<?php
fileLoader::load('filters/iFilter');
fileLoader::load('filters/filterChain');
fileLoader::load('cases/filters/stubFilter.class');
fileLoader::load('request/httpResponse');
fileLoader::load('request/httpRequest');

mock::generate('httpRequest');

class filterChainTest extends UnitTestCase
{
    private $filterChain;

    function setup()
    {
        $request = new mockhttpRequest;

        // Smarty в этих тестах не нужен, заменяем пустым объектом
        $response = new httpResponse(new stdClass());

        $this->filterChain = new filterChain($response, $request);
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
        $this->filterChain->registerFilter($filter, 'another');

        ob_start();
        $this->filterChain->process();
        $response = ob_get_contents();
        ob_end_clean();
        $this->assertEqual($response, "<f1><f2><f3></f3></f2></f1>");
    }
}
?>