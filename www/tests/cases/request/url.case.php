<?php

fileLoader::load('request/url');

class urlTest extends unitTestCase
{

    function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testUrlGet()
    {
        $url = new url;
        $section = 'foo';
        $action = 'bar';
        $param1 = 'val1';
        $param2 = 'val2';
        $url->setSection($section);
        $url->setAction($action);
        $url->addParam($param1);
        $url->addParam($param2);
        $this->assertEqual($url->get(), '/foo/val1/val2/bar');
    }

}

?>