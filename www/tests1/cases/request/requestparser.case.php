<?php

class RequestParserTest extends unitTestCase
{
    protected $resolver;
    function setUp()
    {
	$httprequest = new MockHttpRequest();
	$httprequest->setReturnValue('get', '/home/news/list');
        $this->resolver = RequestParser::getInstance();
print_R($httprequest->get());
    }
    
    function testRequestGet()
    {
   	$this->assertEqual($this->resolver->get('action'), 1);
    }
}

?>