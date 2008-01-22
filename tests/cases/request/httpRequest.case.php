<?php

fileLoader::load('request/httpRequest');
fileLoader::load('dataspace/arrayDataspace');

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

        unset($_GET['group']);
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

        $this->assertNull($this->httprequest->get('param_foo', 'mixed', SC_REQUEST));
        $this->assertEqual($this->httprequest->get('param_foo'), 'foo');

        $this->assertEqual($this->httprequest->get('_TEST_FOO', 'mixed', SC_POST), 'post_foo');
        $this->assertEqual($this->httprequest->get('_TEST_BAR', 'mixed', SC_COOKIE), 'cookie_bar');

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEqual($this->httprequest->get('REQUEST_METHOD', 'mixed', SC_SERVER), 'GET');
    }

    public function testGetUnknownValue()
    {
        try {
            $this->httprequest->get('param_foo', '_not_valid');
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/_not_valid/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testGetWithType()
    {
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY', 'mixed', SC_REQUEST), array('array_value'));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY', 'string', SC_REQUEST), 'array_value');

        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'array', SC_REQUEST), array($this->integer));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'integer', SC_REQUEST), (int)$this->integer);

        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER', 'mixed', SC_REQUEST), $this->integer);
        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER', 'integer', SC_REQUEST), (int)$this->integer);
    }

    public function testGetWithUnknownType()
    {
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY', 'mixed', SC_REQUEST), array('array_value'));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY', 'string', SC_REQUEST), 'array_value');

        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'array', SC_REQUEST), array($this->integer));
        $this->assertIdentical($this->httprequest->get('_TEST_ARRAY_INT', 'integer', SC_REQUEST), (int)$this->integer);

        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER', 'mixed', SC_REQUEST), $this->integer);
        $this->assertIdentical($this->httprequest->get('_TEST_INTEGER', 'integer', SC_REQUEST), (int)$this->integer);
    }

    public function testGetWithIndex()
    {
        $_GET['user']['1']['login'][0] = "root";
        $this->httprequest->refresh();
        $this->assertEqual($this->httprequest->get("user[1]['login'][]", 'mixed', SC_REQUEST), 'root');
    }

    public function testGetUrl()
    {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = '8080';
        $_SERVER['HTTP_HOST'] = 'www.mzz.ru';
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
        $this->assertEqual($this->httprequest->getRequestUrl(), 'http://www.mzz.ru' . SITE_PATH . '/news/%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%B8%D0%B9/18/10/2005/list?_TEST_INTEGER=2006');
    }


    public function testGetPath()
    {
        $this->assertEqual($this->httprequest->getPath(), 'news/%D1%80%D1%83%D1%81%D1%81%D0%BA%D0%B8%D0%B9/18/10/2005/list');
    }

    public function testGetSection()
    {
        $this->httprequest->setSection($section = 'news');
        $this->assertEqual($this->httprequest->getSection(), $section);
    }

    public function testGetAction()
    {
        $this->httprequest->setAction($action = 'news');
        $this->assertEqual($this->httprequest->getAction(), $action);
    }

    public function testGetParams()
    {
        $this->httprequest->setParams($params = array('someKey' => 'someValue'));
        $this->assertEqual($this->httprequest->get('someKey'), $params['someKey']);
    }

    public function testSaveRestore()
    {
        $this->httprequest->setParams($paramsFirst = array('key' => 'hello'));
        $this->assertEqual($this->httprequest->get('key'), $paramsFirst['key']);

        $this->httprequest->save();

        $this->httprequest->setParams($paramsSecond = array('index' => 'world'));
        $this->assertEqual($this->httprequest->get('index'), $paramsSecond['index']);

        $this->httprequest->save();

        $this->httprequest->setParams($paramsSecond = array('index' => 'foo'));
        $this->assertEqual($this->httprequest->get('index'), $paramsSecond['index']);

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->get('index'), 'world');

        $this->httprequest->restore();

        $this->assertEqual($this->httprequest->get('key'), $paramsFirst['key']);
        $this->assertEqual($this->httprequest->get('index'), null);
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