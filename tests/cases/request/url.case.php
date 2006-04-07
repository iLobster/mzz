<?php

fileLoader::load('request/url');

class urlTest extends unitTestCase
{

    function setUp()
    {
        if(!isset($_SERVER['HTTP_HOST'])) {
            $_SERVER['HTTP_HOST'] = 'localhost';
        }
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

    public function testUrlWithoutParams()
    {
        $url = new url;
        $section = 'foo';
        $action = 'bar';
        $url->setSection($section);
        $url->setAction($action);
        $this->assertEqual($url->get(), '/foo/bar');
    }

    public function testUrlFull()
    {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $address = $protocol . '://' . $_SERVER['HTTP_HOST'];

        $url = new url;
        $section = 'foo';
        $action = 'bar';
        $param1 = 'val1';
        $param2 = 'val2';
        $url->setSection($section);
        $url->setAction($action);
        $url->addParam($param1);
        $url->addParam($param2);
        $this->assertEqual($url->getFull(), $address . '/foo/val1/val2/bar');
    }

    public function testUrlFullWithoutParams()
    {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $address = $protocol . '://' . $_SERVER['HTTP_HOST'];

        $url = new url;
        $section = 'foo';
        $action = 'bar';
        $url->setSection($section);
        $url->setAction($action);
        $this->assertEqual($url->getFull(), $address . '/foo/bar');
    }

}

?>