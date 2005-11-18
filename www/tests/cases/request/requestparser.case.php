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
        // ������ ��������, � ���� ������ ����� 10, � � ����� 18 � ��� ���� ���� �����������. ������� �������?

        $this->httprequest->setReturnValue('get', '////news/archive///10//////10//2005///////list////');
        $this->requestparser = RequestParser::getInstance($this->httprequest);
        $this->assertEqual($this->requestparser->get('action'), 'list');
        $this->assertEqual($this->requestparser->get('section'), 'news');
        $this->assertEqual($this->requestparser->get('params'), array('archive', 18, 10, 2005, 'list'));
	
    }
}

?>