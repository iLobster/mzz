<?php

fileLoader::load('template/plugins/function.add');
fileLoader::load('cases/smarty/stubSmarty');

mock::generate('stubSmarty');

class mzzSmartyAddFunctionTest extends unitTestCase
{
    protected $smarty;
    public function setUp()
    {
        $this->smarty = new mockstubSmarty();
    }

    private function setUpExpectOnce($tpl)
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => $tpl . '.tpl')));
        $this->smarty->expectOnce('get_template_vars', array('css'));
        $this->smarty->setReturnValue('get_template_vars', array());
    }

    private function setUpExpectOnceJS()
    {
        $this->smarty->expectOnce('append', array('js', array('file' => 'script.js', 'tpl' => 'js.tpl')));
        $this->smarty->expectOnce('get_template_vars', array('js'));
        $this->smarty->setReturnValue('get_template_vars', array());
    }

    public function testNoResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'style.css');
        smarty_function_add($params, $this->smarty);
    }

    public function testWithResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'css:style.css');
        smarty_function_add($params, $this->smarty);
    }

    public function testNoResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }

    public function testWithResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'css:style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }

    public function testURLAsFilenameWithTemplate()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css?a&b=1', 'tpl' => 'some.tpl')));
        $this->smarty->setReturnValue('get_template_vars', array());
        $params = array('file' => 'css:style.css?a&b=1', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }

    public function testTypoResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => ':style.css');
        smarty_function_add($params, $this->smarty);
    }

    public function testTypoFilenameWithTemplate()
    {
        $this->smarty->expectNever('append');
        $params = array('file' => 'css:sty:le.css');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/имя файла.*sty:le\.css.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testErrorResourceWithTemplate()
    {
        $this->smarty->expectNever('append');
        $params = array('file' => 'wrong:style.css');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/тип ресурса.*wrong.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testNoFilename()
    {
        $this->smarty->expectNever('append');
        $params = array('tpl' => 'asd.tpl');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/аттрибут.*file.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testEmptyFilenameWithTemplate()
    {
        $this->smarty->expectNever('append');
        $params = array('file' => '', 'tpl' => 'some.tpl');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/аттрибут.*file.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testJSNoResourceNameNoTemplate()
    {
        $this->setUpExpectOnceJS();
        $params = array('file' => 'script.js');
        smarty_function_add($params, $this->smarty);
    }

    public function testJSResourceNameNoTemplate()
    {
        $this->setUpExpectOnceJS();
        $params = array('file' => 'js:script.js');
        smarty_function_add($params, $this->smarty);
    }

    public function testAddOnce()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => 'css.tpl')));
        $this->smarty->expectCallCount('get_template_vars', 2);
        $this->smarty->setReturnValueAt(0, 'get_template_vars', array());
        $this->smarty->setReturnValueAt(1, 'get_template_vars', array(array('file' => 'style.css', 'tpl' => 'css.tpl')));
        $params = array('file' => 'style.css');
        smarty_function_add($params, $this->smarty);
        smarty_function_add($params, $this->smarty);
    }
}

?>