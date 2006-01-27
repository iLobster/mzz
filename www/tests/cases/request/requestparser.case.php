<?php

fileLoader::load('request/httpRequest');
fileLoader::load('request/requestParser');

Mock::generate('httpRequest');

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
        $this->requestparser = new requestParser();
    }

    public function tearDown()
    {
        unset($_GET['path']);
    }


    public function testRequestPathParser()
    {
        $this->httprequest->expectOnce('setSection', array('news'));
        $this->httprequest->expectOnce('setAction', array('list'));
        $this->httprequest->expectOnce('setParams', array(array('archive', '18', '10', '2005')));
        $this->requestparser->parse($this->httprequest, $_GET['path']);
    }
}

?>