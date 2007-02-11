<?php

fileLoader::load('controller/frontController');
fileLoader::load('request/httpRequest');
mock::generate('httpRequest');

class frontControllerTest extends unitTestCase
{
    private $frontController;
    private $request;

    public function setUp()
    {
        $this->request = new mockhttpRequest();
        $this->frontController = new frontController($this->request, dirname(__FILE__) . '/fixtures');
    }

    public function testFrontController()
    {
        $this->request->expectOnce('getSection', array());
        $this->request->setReturnValue('getSection', 'test');

        $this->request->expectOnce('getAction', array());
        $this->request->setReturnValue('getAction', 'bar');

        $this->assertEqual($this->frontController->getTemplateName(), "act/test/bar.tpl");
    }

    public function testSectionMapperFalse()
    {
        $section = "__not_exists__";
        $action = "__not_exists__";

        try {
            $this->frontController->getTemplateName($section, $action);
            $this->fail('Не было брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/Не найден активный шаблон/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }

        $section = "test";
        $action = "__not_exists__";

        try {
            $this->frontController->getTemplateName($section, $action);
            $this->fail('Не было брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/Не найден активный шаблон/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

}

?>