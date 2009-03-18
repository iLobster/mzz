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

        $this->smarty->expectOnce('assign_by_ref', array('media', $statics['medias']));
    }

    private function setUpExpectOnceJS()
    {
        $this->smarty->expectOnce('get_template_vars', array('media'));
        $this->smarty->setReturnValue('get_template_vars', array());
    }

    private function findMatches($type, $file, $array)
    {
        $statics = $this->function->getStaticVariables();
        $this->assertTrue(isset($statics['medias'][$type]));

        return (isset($statics['medias'][$type][$file]) && $statics['medias'][$type][$file] === $array);
    }

    public function testAddFile()
    {
        $params = array(
            'file' => 'style.css'
        );

        smarty_function_add($params, $this->smarty);
        $statics = $this->function->getStaticVariables();

        $this->assertTrue($this->findMatches('css', $params['file'], array('tpl' => 'css.tpl', 'join' => true)));
    }

    public function testAddFileWithNoJoin()
    {
        $params = array(
            'file' => 'style.css',
            'join' => false
        );

        smarty_function_add($params, $this->smarty);
        $statics = $this->function->getStaticVariables();

        $this->assertTrue($this->findMatches('css', $params['file'], array('tpl' => 'css.tpl', 'join' => false)));
    }

    public function testAddTwice()
    {
        $params = array(
            'file' => 'style.css',
            'join' => false
        );

        smarty_function_add($params, $this->smarty);
        $statics = $this->function->getStaticVariables();

        $this->assertTrue($this->findMatches('css', $params['file'], array('tpl' => 'css.tpl', 'join' => false)));

        $params['join'] = true;

        smarty_function_add($params, $this->smarty);
        $statics = $this->function->getStaticVariables();

        $this->assertTrue($this->findMatches('css', $params['file'], array('tpl' => 'css.tpl', 'join' => true)));
    }

    public function testNoResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'style.css');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', $params['file'], array('tpl' => 'css.tpl', 'join' => true));
        $this->assertTrue($match);
    }

    public function testWithResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('css');
        $params = array('file' => 'css:style2.css');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', 'style2.css', array('tpl' => 'css.tpl', 'join' => true));
        $this->assertTrue($match);
    }

    public function testNoResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'style.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', $params['file'], array('tpl' => 'some.tpl', 'join' => true));
        $this->assertTrue($match);
    }

    public function testWithResourceNameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'css:style3.css', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', 'style3.css', array('tpl' => 'some.tpl', 'join' => true));
        $this->assertTrue($match);
    }

    public function testURLAsFilenameWithTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'css:style.css?a&b=1', 'tpl' => 'some.tpl');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('css', 'style.css?a&b=1', array('tpl' => 'some.tpl', 'join' => true));
        $this->assertTrue($match);
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
        $match = $this->findMatches('js', $params['file'], array('tpl' => 'js.tpl', 'join' => true));
        $this->assertTrue($match);
    }

    public function testJSResourceNameNoTemplate()
    {
        $this->setUpExpectOnce('some');
        $params = array('file' => 'js:script2.js');
        smarty_function_add($params, $this->smarty);
        $match = $this->findMatches('js', 'script2.js', array('tpl' => 'js.tpl', 'join' => true));
        $this->assertTrue($match);
    }


    /*
    public function testAddOnce()
    {
        $name = 'style_testAddOnce.css';
        $params = array('file' => $name);
        $before = $this->findMatches('css', $name, array('tpl' => 'css.tpl', 'join' => false));
        $this->assertFalse($before);
        smarty_function_add($params, $this->smarty);
        smarty_function_add($params, $this->smarty);
        $params = array('file' => 'css:' . $name);
        smarty_function_add($params, $this->smarty);
        $params = array('file' => 'css:' . $name, 'tpl' => 'css.tpl');
        smarty_function_add($params, $this->smarty);
        $after = $this->findMatches('css', $name, array('tpl' => 'css.tpl', 'join' => true));
        $this->assertTrue($after);
    }*/
}

?>