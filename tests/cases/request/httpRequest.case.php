<?php

fileLoader::load('request/httpRequest');

class httpRequestTest extends unitTestCase
{
    protected $httprequest;
    // Суперглобальные переменные до запуска теста
    protected $SERVER = array();
    protected $GET = array();
    protected $POST = array();
    protected $COOKIE = array();
    protected $REQUEST = array();

    protected $integer = '2006';
    protected $float = '2.1';

    function setUp()
    {
        $this->SERVER = $_SERVER;
        $this->POST = $_POST;
        $this->GET = $_GET;
        $this->COOKIE = $_COOKIE;
        $this->REQUEST = $_REQUEST;


        $_GET['path'] = "/news/русский/18/10//2005/list";
        $_POST['_TEST_FOO'] = "post_foo";
        $_COOKIE['_TEST_BAR'] = "cookie_bar";

        $_POST['_TEST_ARRAY'][0] = "array_value";
        $_POST['_TEST_ARRAY_INT'][0] = $this->integer;
        $_GET['_TEST_INTEGER'] = $this->integer;
        $_COOKIE['_TEST_FLOAT'] = $this->float;

        $this->httprequest = new httpRequest();
    }

    public function tearDown()
    {
        $_SERVER = $this->SERVER;
        $_POST = $this->POST;
        $_GET = $this->GET;
        $_COOKIE = $this->COOKIE;
        $_REQUEST = $this->REQUEST;
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


    public function testIsAjax()
    {
        $this->assertFalse($this->httprequest->isAjax());
        $_REQUEST['ajax'] = 1;
        $this->assertTrue($this->httprequest->isAjax());
    }

    public function testGet()
    {
        $this->httprequest->setParam('param_foo', 'foo');

        $this->assertNull($this->httprequest->getRaw('param_foo', SC_REQUEST));
        $this->assertEqual($this->httprequest->getRaw('param_foo'), 'foo');

        $this->assertEqual($this->httprequest->getRaw('_TEST_FOO', SC_POST), 'post_foo');
        $this->assertEqual($this->httprequest->getRaw('_TEST_BAR', SC_COOKIE), 'cookie_bar');

        $this->assertEqual($this->httprequest->getRaw('_TEST_FOO', SC_GET), null);

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->getServer('REQUEST_METHOD'), 'GET');
    }
/*
    public function testGetUnknownValue()
    {
        try {
            $this->httprequest->get('param_foo', '_not_valid');
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/_not_valid/i", $e->getMessage());
            $this->pass();
        }
    }*/

    public function testGetWithType()
    {
        $this->assertIdentical($this->httprequest->getRaw('_TEST_ARRAY', SC_REQUEST), array('array_value'));
        $this->assertIdentical($this->httprequest->getString('_TEST_ARRAY', SC_REQUEST), 'array_value');

        $this->assertIdentical($this->httprequest->getArray('_TEST_ARRAY_INT', SC_REQUEST), array($this->integer));
        $this->assertIdentical($this->httprequest->getInteger('_TEST_ARRAY_INT', SC_REQUEST), (int)$this->integer);


        $this->assertIdentical($this->httprequest->getRaw('_TEST_INTEGER', SC_REQUEST), $this->integer);
        $this->assertIdentical($this->httprequest->getInteger('_TEST_INTEGER', SC_REQUEST), (int)$this->integer);
        $this->assertIdentical($this->httprequest->getString('_TEST_INTEGER', SC_REQUEST), (string)$this->integer);
        $this->assertIdentical($this->httprequest->getBoolean('_TEST_INTEGER', SC_REQUEST), (bool)$this->integer);
        $this->assertIdentical($this->httprequest->getArray('_TEST_INTEGER', SC_REQUEST), array($this->integer));
        $this->assertIdentical($this->httprequest->getNumeric('_TEST_FLOAT', SC_COOKIE), (float)$this->float);
    }

    public function testGetWithDefault()
    {
        $this->assertIdentical($this->httprequest->getRaw('__blah_blah', SC_REQUEST), null);
        $this->assertIdentical($this->httprequest->getInteger('__blah_blah', SC_REQUEST), null);

        $this->assertIdentical($this->httprequest->getString('__blah_blah', SC_REQUEST, 'default_val'), 'default_val');
        $this->assertIdentical($this->httprequest->getBoolean('__blah_blah', SC_REQUEST, true), true);
        $this->assertIdentical($this->httprequest->getArray('__blah_blah', SC_REQUEST, 'default_val'), array('default_val'));
        $this->assertIdentical($this->httprequest->getNumeric('__blah_blah', SC_REQUEST, 33), 33);
        $this->assertIdentical($this->httprequest->getInteger('__blah_blah', SC_REQUEST, 33), 33);
        $this->assertIdentical($this->httprequest->getRaw('__blah_blah', SC_REQUEST, 'default_val'), 'default_val');
    }

    public function testGetWithIndex()
    {
        $_GET['user']['1']['login'][0] = "root";
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getRaw("user[1]['login'][]", SC_REQUEST), 'root');
    }

    public function testGetUrl()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = '8080';
        $_SERVER['HTTP_HOST'] = null;
        $_SERVER['SERVER_NAME'] = 'www.mzz.ru';
        $_GET['path'] = "/news/";
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getUrl(), 'https://www.mzz.ru:8080' . SITE_PATH);
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru:8080';
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getUrl(), 'https://www.mzz.ru:8080' . SITE_PATH);
    }

    public function testGetRequestUrl()
    {
        $_SERVER['HTTPS'] = false;
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru';
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getRequestUrl(), 'http://www.mzz.ru' . SITE_PATH . '/news/русский/18/10/2005/list?_TEST_INTEGER=2006');
    }

    public function testUrlPort()
    {
        $port = '8080';
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru:' . $port;
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getUrlPort(), $port);

        unset($_SERVER['HTTP_HOST']);
        $port = '8081';
        $_SERVER['SERVER_NAME'] = 'www.mzz.ru:' . $port;
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->getUrlPort(), $port);
    }


    public function testGetPath()
    {
        $this->assertEqual($this->httprequest->getPath(), 'news/русский/18/10/2005/list');
    }

    public function testGetModule()
    {
        $this->httprequest->setModule($module = 'news');
        $this->assertEqual($this->httprequest->getModule(), $module);
    }

    public function testGetAction()
    {
        $this->httprequest->setAction($action = 'view');
        $this->assertEqual($this->httprequest->getAction(), $action);
    }

    public function testGetParams()
    {
        $this->httprequest->setParams($params = array('someKey' => 'someValue'));
        $this->assertEqual($this->httprequest->getRaw('someKey'), $params['someKey']);
    }


    public function testGetRequested()
    {
        $this->httprequest->setModule($module = 'news');
        $this->httprequest->setAction($action = 'view');
        $this->httprequest->setParam('id', 12);
        $this->httprequest->setParam('type', 1);
        $this->httprequest->setRequestedParams($this->httprequest->getParams());

        $this->assertEqual($this->httprequest->getRequestedModule(), $module);
        $this->assertEqual($this->httprequest->getRequestedAction(), $action);
        $this->assertEqual($this->httprequest->getRequestedParams(), array('id' => 12, 'type' => 1));

        $this->httprequest->setModule('page');
        $this->httprequest->setAction('list');
        $this->httprequest->setParam('cat', 'hello');
        $this->httprequest->setRequestedParams($this->httprequest->getParams());

        $this->assertEqual($this->httprequest->getRequestedModule(), $module);
        $this->assertEqual($this->httprequest->getRequestedAction(), $action);
        $this->assertEqual($this->httprequest->getRequestedParams(), array('id' => 12, 'type' => 1));
    }

    public function testGetHeaders()
    {
        $_SERVER = array();
        $_SERVER['HTTP_CONNECTION'] = 'GET';
        $_SERVER['HTTP_USER_AGENT'] = 'Browser';
        $_SERVER['CONTENT_TYPE'] = 'text/html';
        // проверяется только получение заголовков без встроенных функций
        $this->assertEqual($this->httprequest->getHeaders(true), array(
            'Connection' => 'GET',
            'User-Agent' => 'Browser',
            'Content-Type' => 'text/html'
        ));
    }

    public function testSaveRestore()
    {
        $this->httprequest->setParams($paramsFirst = array('key' => 'hello'));
        $this->assertEqual($this->httprequest->getRaw('key'), $paramsFirst['key']);

        $this->httprequest->save();

        $this->httprequest->setParams($paramsSecond = array('index' => 'world'));
        $this->assertEqual($this->httprequest->getRaw('index'), $paramsSecond['index']);

        $this->httprequest->save();

        $this->httprequest->setParams($paramsSecond = array('index' => 'foo'));
        $this->assertEqual($this->httprequest->getRaw('index'), $paramsSecond['index']);

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->getRaw('index'), 'world');

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->getRaw('key'), $paramsFirst['key']);
        $this->assertEqual($this->httprequest->getRaw('index'), null);
    }

    public function testRestoreWithoutSave()
    {
        $this->assertFalse($this->httprequest->restore());
        $this->httprequest->save();
        $this->assertTrue($this->httprequest->restore());
        $this->assertFalse($this->httprequest->restore());
    }
}

?>