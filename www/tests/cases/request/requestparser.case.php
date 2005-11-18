<?php
require_once 'cases/request/httprequest.class.php';
require_once '../../system/request/requestparser.php';
Mock::generate('httprequest');


class RequestParserTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;
    function setUp() {
        $this->httprequest = new MockHttpRequest();
    }
    function testRequestPathParser()
    {
        $this->httprequest->setReturnValue('get', '/news/archive/18/10/2005/list');
        $this->requestparser = RequestParser::getInstance($this->httprequest);

        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');
        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));
	
    }   

    function testRequestDirtyPathParser()
    {
        // ќбрати внимание, в пути первое число 10, а в тесте 18 и при этом тест срабатывает. ѕричина пон€тна?

        $this->httprequest->setReturnValue('get', '////news/archive///10//////10//2005///////list////');
        $this->requestparser = RequestParser::getInstance($this->httprequest);
        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');
        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));
	
    }
}

?>