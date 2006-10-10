<?php

fileLoader::load('request/httpRequest');
fileLoader::load('dataspace/arrayDataspace');

class httpRequestTest extends unitTestCase
{
    protected $httprequest;
    // —уперглобальные переменные до запуска теста
    protected $SERVER = array();
    protected $GET = array();
    protected $POST = array();
    protected $COOKIE = array();

    protected $integer = '2006';

    function setUp()
    {
        $this->SERVER = $_SERVER;
        $this->POST = $_POST;
        $this->GET = $_GET;
        $this->COOKIE = $_COOKIE;


        $_GET['path'] = "/news/archive/18/10//2005/list";
        $_POST['_TEST_FOO'] = "post_foo";
        $_COOKIE['_TEST_BAR'] = "cookie_bar";

        $_POST['_TEST_ARRAY'][0] = "array_value";
        $_POST['_TEST_ARRAY_INT'][0] = $this->integer;
        $_GET['_TEST_INTEGER'] = $this->integer;

        $this->httprequest = new httpRequest();


    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
        $_POST = $this->POST;
        $_GET = $this->GET;
        $_COOKIE = $this->COOKIE;
    }


    public function testIsSecure()
    {
        // for Apache
        unset($_SERVER['HTTPS']);
        $this->assertFalse($this->httprequest->isSecure());

        // for IIS
        $_SERVER['HTTPS'] = "off";
        $this->assertFalse($this->httprequest->isSecure());

        $_SERVER['HTTPS'] = "on";
        $this->assertTrue($this->httprequest->isSecure());
    }

    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->getMethod(), 'GET');
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertEqual($this->httprequest->getMethod(), 'POST');
    }


    public function testGet()
    {
        $this->httprequest->setParam('param_foo', 'foo');
        $this->assertNull($this->httprequest->get('__NOT_EXISTS__'));
        $this->assertNull($this->httprequest->get('__NOT_EXISTS__', 'string', SC_PATH));

        $this->assertNull($this->httprequest->get('param_foo'));
        $this->assertEqual($this->httprequest->get('param_foo', 'mixed', SC_PATH), 'foo');

        $this->assertEqual($this->httprequest->get('_TEST_FOO'), 'post_foo');
        $this->assertEqual($this->httprequest->get('_TEST_BAR', 'mixed', SC_COOKIE), 'cookie_bar');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->get('REQUEST_METHOD', 'mixed', SC_SERVER), 'GET');
    }

    public function testGetWithType()
    {
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY'), array('array_value'));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY', 'string'), 'array_value');

        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'array'), array($this->integer));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'integer'), (int)$this->integer);

        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER'), $this->integer);
        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER', 'integer'), (int)$this->integer);
    }

    public function testGetUrl()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = '8080';
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru';
        $_GET['path'] = "/news/";
        $this->assertEqual($this->httprequest->getUrl(), 'https://www.mzz.ru:8080');
    }

    public function testGetRequestUrl()
    {
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru';
        $this->assertEqual($this->httprequest->getRequestUrl(), 'http://www.mzz.ru/news/archive/18/10/2005/list');
    }


    public function testGetPath()
    {
        $_GET['path'] = "/news///archive/18/10//2005/list";
        $this->assertEqual($this->httprequest->getPath(), 'news/archive/18/10/2005/list');
    }

    public function testGetSection()
    {
        $this->httprequest->setParams($params = array('section' => 'example'));
        $this->assertEqual($this->httprequest->getSection(), $params['section']);
    }

    public function testGetParams()
    {
        $this->httprequest->setParams($params = array('someKey' => 'someValue'));
        $this->assertEqual($this->httprequest->get('someKey', 'mixed', SC_PATH), $params['someKey']);
    }

    public function testSaveRestore()
    {
        $this->httprequest->setParams($paramsFirst = array('key' => 'hello'));
        $this->assertEqual($this->httprequest->get('key', 'mixed', SC_PATH), $paramsFirst['key']);

        $this->httprequest->save();

        $this->httprequest->setParams($paramsSecond = array('index' => 'world'));
        $this->assertEqual($this->httprequest->get('index', 'mixed', SC_PATH), $paramsSecond['index']);

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->get('key', 'mixed', SC_PATH), $paramsFirst['key']);
        $this->assertEqual($this->httprequest->get('index', 'mixed', SC_PATH), null);
    }
}

?>