<?php
fileLoader::load('request/httpResponse');

class httpResponseTest extends unitTestCase
{
    protected $response;

    function setUp()
    {
        $this->response = new httpResponse();
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
        $headers = array(
        'name1' => array('value' => 'value_1', 'replaced' => 1, 'code' => null),
        'name2' => array('value' => 'value_2', 'replaced' => 1, 'code' => null),
        '' => array('value' => 'value3', 'replaced' => 1, 'code' => 403)
        );


        foreach ($headers as $name => $values) {
            $this->response->setHeader($name, $values['value'], $values['replaced'], $values['code']);
        }

        $this->assertEqual($this->response->getHeaders(), $headers);
    }

    public function testSetHeadersWithoutReplace()
    {
        $headers = array(
        'name1' => array('value' => 'value_1', 'replaced' => 1, 'code' => null),
        'name2' => array('value' => 'value_2', 'replaced' => 1, 'code' => null),
        );

        foreach ($headers as $name => $values) {
            $this->response->setHeader($name, $values['value'], $values['replaced'], $values['code']);
        }
        for ($i = 3; $i <= 4; $i++) {
            $this->response->setHeader($name, 'value_' . $i, 0, $values['code']);
        }

        $headers['name2#'] = array('value' => 'value_3', 'replaced' => 0, 'code' => null);
        $headers['name2##'] = array('value' => 'value_4', 'replaced' => 0, 'code' => null);

        $this->assertEqual($this->response->getHeaders(), $headers);
    }

    public function testSetCookies()
    {

        $name = 'test';
        $cookie = array('value' => '1', 'domain' => COOKIE_DOMAIN);
        $this->response->setCookie($name, $cookie['value']);
        $cookies = $this->response->getCookies();
        $this->assertEqual($cookies[$name]['domain'], $cookie['domain']);

        $name = 'test';
        $cookie = array('value' => '1', 'expire' => 0, 'path' => '/path', 'domain' => 'example.com', 'secure' => 1, 'httponly' => 1);
        $this->response->setCookie($name, $cookie['value'], $cookie['expire'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);

        $this->assertEqual($this->response->getCookies(), array($name => $cookie));
    }

    public function testRedirect()
    {
        $url = 'http://example.com/path';
        $this->response->redirect($url);
        $this->assertEqual($this->response->getHeaders(), array('Location' => array('value' => $url, 'replaced' => 1, 'code' => 302)));
        $this->response->redirect($url, 304);
        $this->assertEqual($this->response->getHeaders(), array('Location' => array('value' => $url, 'replaced' => 1, 'code' => 304)));
    }

    public function testStausCode()
    {
        $this->response->setStatus($code = 404);
        $this->assertEqual($this->response->getStatus(), 404);
    }

    public function testInvalidRedirectCode()
    {
        try {
            $this->response->redirect('/', 404);
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->pass();
        }
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