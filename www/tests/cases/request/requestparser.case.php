<?php

fileLoader::load('request/httprequest');
//fileLoader::load('cases/request/httprequest.class');
fileLoader::load('request/requestparser');

//Mock::generate('httprequeststub');

class RequestParserTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;

    function setUp()
    {
        $_GET['path'] = "/news/archive/18/10/2005/list";
        $this->httprequest = new HttpRequest();
    }

    public function tearDown()
    {
        unset($this->mock);
    }


    public function testRequestPathParser()
    {
        //$this->httprequest->setReturnValue('get', '/news/archive/18/10/2005/list');

        $this->assertEqual($this->httprequest->getAction(), 'list');
        $this->assertEqual($this->httprequest->getSection(), 'news');

        $this->assertEqual($this->httprequest->getParams(), array('archive', 18, 10, 2005, 'list'));

    }

/*
    public function testRequestDirtyPathParser()
    {
        $this->httprequest->setReturnValue('get', '////news/archive///10//////10//2005///////list////');
        $this->requestparser = RequestParser::getInstance($this->httprequest);

        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');

        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));

    }*/


}

?>