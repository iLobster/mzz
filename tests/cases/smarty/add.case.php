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

    public function testNoResourceNameNoTemplate()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => 'css.tpl')));
        $params = array('file' => 'style.css');
        smarty_function_add($params, $this->smarty);
    }

    public function testWithResourceNameNoTemplate()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => 'css.tpl')));
        $params = array('file' => 'css:style.css');
        smarty_function_add($params, $this->smarty);
    }

    public function testNoResourceNameWithTemplate()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => 'some.tpl')));
        $params = array('file' => 'style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }

    public function testWithResourceNameWithTemplate()
    {
        $this->smarty->expectOnce('append', array('css', array('file' => 'style.css', 'tpl' => 'some.tpl')));
        $params = array('file' => 'css:style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }

    public function testNoFilenameWithTemplate()
    {
        $this->smarty->expectNever('append');
        $params = array('file' => '', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
    }
}

?>