<?php
fileLoader::load('request/httpResponse');

class stubTemplateEngine
{
    function assign($name, $value) {}
}
mock::generate('stubTemplateEngine');

class httpResponseTest extends unitTestCase
{
    protected $response;
    protected $smarty;

    function setUp()
    {
        $this->smarty = new mockstubTemplateEngine;
        $this->response = new httpResponse($this->smarty);
    }

    public function tearDown()
    {
    }

    public function testHttpResponse()
    {
        $this->response->append('test_add');
        $this->response->append('_content');
        $this->response->append('_done');

        // start buffer
        ob_start();
        $this->response->send();
        // read buffer
        $content = ob_get_contents();
        // and clean buffer
        ob_end_clean();

        $this->assertEqual($content, 'test_add_content_done');
    }

    public function testSetHeaders()
    {
        $headers = array('name1' => 'value_1', 'name2' => 'value_2', 'name3' => 'value_3');
        foreach ($headers as $name => $value) {
            $this->response->setHeader($name, $value);
        }

        $this->assertEqual($this->response->getHeaders(), $headers);
    }

    public function testSetCookies()
    {
        $name = 'test';
        $cookie = array('value' => '1', 'expire' => 0, 'path' => '/path', 'domain' => 'example.com', 'secure' => 1, 'httponly' => 1);
        $this->response->setCookie($name, $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);

        $this->assertEqual($this->response->getCookies(), array($name => $cookie));
    }

    public function testSetTitle()
    {
        $this->smarty->expectOnce('assign', array('title', 'test_title_value'));
        $this->response->setTitle('test_title_value');
    }

    public function testRedirect()
    {
        $url = 'http://example.com/path';
        $this->response->redirect($url);

        $this->assertEqual($this->response->getHeaders(), array('Location' => $url));
    }

    public function testClear()
    {
        $this->response->append('foo');

        // start buffer
        ob_start();
        $this->response->send();
        // read buffer
        $content = ob_get_contents();
        // and clean buffer
        ob_end_clean();

        $this->assertEqual($content, 'foo');

        $this->response->clear();

        // start buffer
        ob_start();
        $this->response->send();
        // read buffer
        $content = ob_get_contents();
        // and clean buffer
        ob_end_clean();

        $this->assertEqual($content, '');
    }
}

?>