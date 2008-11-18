<?php

fileLoader::load('template/plugins/function.add');
fileLoader::load('cases/smarty/stubSmarty');

mock::generate('stubSmarty');

class mzzSmartyAddFunctionTest extends unitTestCase
{
    protected $smarty;
    protected $function;

    public function setUp()
    {
        $this->smarty = new mockstubSmarty();
        $this->function = new ReflectionFunction('smarty_function_add');
        smarty_function_add(array('init' => true), $this->smarty);
    }

    private function setUpExpectOnce($tpl)
    {
        $this->assertNotNull($statics = $this->function->getStaticVariables());
        $this->assertTrue(isset($statics['medias']), 'изменено имя static-переменной');

        $this->smarty->expectOnce('assign_by_ref', array('media', $statics['medias'][1]));
    }

    private function setUpExpectOnceJS()
    {
        $this->smarty->expectOnce('get_template_vars', array('media'));
        $this->smarty->setReturnValue('get_template_vars', array());
    }

    private function findMatches($type, $array)
    {
        $statics = $this->function->getStaticVariables();
        $match = 0;
        $this->assertTrue(isset($statics['medias'][1]['css']));
        foreach ($statics['medias'][1][$type] as $css) {
            if ($css == $array) {
                $match++;
            }
        }
        return $match;
    }

    public function testWithJoinNotSetted()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'joinedstyle.css');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'joinedstyle.css', 'tpl' => 'css.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testWithJoinSettedInFalse()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'notjoinedstyle.css', 'join' => false);
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'notjoinedstyle.css', 'tpl' => 'css.tpl', 'join' => false));
        $this->assertEqual($match, 1);
    }

    public function testNoResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'style.css');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'style.css', 'tpl' => 'css.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testWithResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'css:style2.css');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'style2.css', 'tpl' => 'css.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testNoResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'style.css', 'tpl' => 'some.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testWithResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'css:style3.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'style3.css', 'tpl' => 'some.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testURLAsFilenameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'css:style.css?a&b=1', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', array('file' => 'style.css?a&b=1', 'tpl' => 'some.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testNameWithEmptyResource()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => ':style.css');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/имя файла.*:style\.css.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testTypoFilenameWithTemplate()
    {
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
        $params = array('tpl' => 'asd.tpl');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/атрибут.*file.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testEmptyFilenameWithTemplate()
    {
        $params = array('file' => '', 'tpl' => 'some.tpl');
        try {
            smarty_function_add($params, $this->smarty);
            $this->fail('no exception thrown?');
        } catch (Exception $e) {
            $this->assertPattern("/атрибут.*file.*$/i", $e->getMessage());
            $this->pass();
        }
    }

    public function testJSNoResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'script.js');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('js', array('file' => 'script.js', 'tpl' => 'js.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testJSResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'js:script2.js');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('js', array('file' => 'script2.js', 'tpl' => 'js.tpl', 'join' => true));
        $this->assertEqual($match, 1);
    }

    public function testAddOnce()
    {
        $name = 'style_testAddOnce.css';
        $params = array('file' => $name);
        $before = $this->findMatches('css', array('file' => $name, 'tpl' => 'css.tpl'));
        $this->assertEqual($before, 0);
        smarty_function_add($params, $this->smarty);
        smarty_function_add($params, $this->smarty);
        $params = array('file' => 'css:' . $name);
        smarty_function_add($params, $this->smarty);
        $params = array('file' => 'css:' . $name, 'tpl' => 'css.tpl');
        smarty_function_add($params, $this->smarty);
        $after = $this->findMatches('css', array('file' => $name, 'tpl' => 'css.tpl', 'join' => true));
        $this->assertEqual($after, 1, 'Сохранено более чем одной записи о ресурсе ' . $name);
    }
}

?>