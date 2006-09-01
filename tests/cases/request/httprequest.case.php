<?php

fileLoader::load('request/httpRequest');
fileLoader::load('request/requestParser');
fileLoader::load('dataspace/arrayDataspace');

Mock::generate('requestParser');

class httpRequestTest extends unitTestCase
{
    protected $requestparser;
    protected $httprequest;
    protected $rewrite;
    // Суперглобальные переменные до запуска теста
    protected $old = array();
    protected $integer = '2006';

    function setUp()
    {
        $this->old['server'] = $_SERVER;
        $this->old['post'] = $_POST;
        $this->old['get'] = $_GET;
        $this->old['cookie'] = $_COOKIE;
        // Тестируется также очистка от лишних "/"
        $_GET['path'] = "/news/archive/18/10//2005/list";
        $_POST['_TEST_FOO'] = "post_foo";
        $_COOKIE['_TEST_BAR'] = "cookie_bar";

        $_POST['_TEST_ARRAY'][0] = "array_value";
        $_POST['_TEST_ARRAY_INT'][0] = $this->integer;
        $_GET['_TEST_INTEGER'] = $this->integer;

        $requestparser = new mockrequestParser();
        $requestparser->expectOnce('parse', array($this->httprequest = new httpRequest($requestparser), $_GET['path']));


    }

    public function tearDown()
    {
        $_SERVER = $this->old['server'];
        $_POST = $this->old['post'];
        $_GET = $this->old['get'];
        $_COOKIE = $this->old['cookie'];
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

    public function testSectionAction()
    {
        $this->assertNull($this->httprequest->getSection());
        $this->assertNull($this->httprequest->getAction());

        $this->httprequest->setSection('foo');
        $this->httprequest->setAction('bar');

        $this->assertEqual($this->httprequest->getSection(), 'foo');
        $this->assertEqual($this->httprequest->getAction(), 'bar');

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
        $_GET['path'] = "/news/archive/18/10//2005/list";
        $this->assertEqual($this->httprequest->getUrl(), $_GET['path']);
    }

    public function testGetParams()
    {
        $this->httprequest->setParams($arr = array(1, 2, 3));
        $this->assertEqual($this->httprequest->getParams(), $arr);
    }

    public function testSaveRestore()
    {
        $this->httprequest->setParam('param_foo', $val = 'foo');
        $this->httprequest->setAction($action = 'someaction');

        $this->assertEqual($this->httprequest->get('param_foo', 'mixed', SC_PATH), $val);
        $this->assertEqual($this->httprequest->getAction(), $action);

        $this->httprequest->save();

        $this->httprequest->setParam('param_foo', $val2 = 'bar');
        $this->httprequest->setAction($action2 = 'someaction2');

        $this->assertEqual($this->httprequest->get('param_foo', 'mixed', SC_PATH), $val2);
        $this->assertEqual($this->httprequest->getAction(), $action2);

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->get('param_foo', 'mixed', SC_PATH), $val);
        $this->assertEqual($this->httprequest->getAction(), $action);
    }
}

?>