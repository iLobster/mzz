<?php

fileLoader::load('request/httpRequest');
fileLoader::load('request/requestParser');

//Mock::generate('httprequeststub');

class RequestParserTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;

    function setUp()
    {
        // Тестируется также очистка от лишних "/"
        $_GET['path'] = "/news/archive/18/10//2005/list";
        $this->httprequest = new HttpRequest();
    }

    public function tearDown()
    {
        unset($_GET['path']);
    }


    public function testRequestPathParser()
    {
        $this->assertEqual($this->httprequest->getAction(), 'list');
        $this->assertEqual($this->httprequest->getSection(), 'news');

        $this->assertEqual($this->httprequest->getParams(), array('archive', 18, 10, 2005, 'list'));

    }
}

?>