<?php
require_once 'cases/request/httprequest.class.php';
require_once '../../system/request/requestparser.php';

Mock::generate('httprequest');

class RequestParserTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;
    
    function setUp()
    {
        $this->httprequest = new MockHttpRequest();
    }
    
    public function tearDown()
    {
        unset($this->mock);
    }
    
    public function testRequestPathParser()
    {
        $this->httprequest->setReturnValue('get', '/news/archive/18/10/2005/list');
        $this->requestparser = RequestParser::getInstance($this->httprequest);

        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');
        
        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));
	
    }   

    public function testRequestDirtyPathParser()
    {
        $this->httprequest->setReturnValue('get', '////news/archive///10//////10//2005///////list////');
        $this->requestparser = RequestParser::getInstance($this->httprequest);
        
        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');
        
        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));
	
    }
}

?>