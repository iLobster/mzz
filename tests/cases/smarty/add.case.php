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
            $this->pass();
        }
    }

    public function testNoFilenameWithTemplate()
    {
        $this->smarty->expectNever('append');
        $params = array('file' => '', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }
}

?>