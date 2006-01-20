<?php

fileLoader::load('request/httpRequest');
fileLoader::load('request/requestParser');
fileLoader::load('request/rewrite');

Mock::generate('httpRequest');
Mock::generate('Rewrite');

class RequestParserTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;
    protected $rewrite;

    function setUp()
    {
        // Тестируется также очистка от лишних "/"
        $_GET['path'] = "/news/archive/18/10//2005/list";
        $this->httprequest = new mockHttpRequest();
        $this->rewrite = new mockRewrite(fileLoader::resolve('configs/rewrite.xml'));
        $this->rewrite->setReturnValue('process', $_GET['path']);
        $this->rewrite->expectOnce('process', array($_GET['path']));
        $this->requestparser = new requestParser($this->rewrite);

    }

    public function tearDown()
    {
        unset($_GET['path']);
    }


    public function testRequestPathParser()
    {
        $this->httprequest->setReturnValue('get', $_GET['path']);
        $this->httprequest->expectCallCount('get', 2);
        $this->httprequest->expectOnce('setSection', array('news'));
        $this->httprequest->expectOnce('setAction', array('list'));
        $this->httprequest->expectOnce('setParams', array(array('archive', '18', '10', '2005')));
        $this->requestparser->parse($this->httprequest);
    }
}

?>