<?php

fileLoader::load('filters/contentFilter');
fileLoader::load('request/httpRequest');
mock::generate('httpRequest');

class contentFilterTest extends unitTestCase
{
    private $contentFilter;
    private $request;
    private $path;

    public function setUp()
    {
        $this->request = new mockhttpRequest();
        $this->path = dirname(__FILE__) . '/fixtures';
        $this->contentFilter = new contentFilter();
    }

    public function testGetTemplate()
    {
        $this->request->expectOnce('getSection', array());
        $this->request->setReturnValue('getSection', 'test');

        $this->request->expectOnce('getAction', array());
        $this->request->setReturnValue('getAction', 'bar');

        $this->assertEqual($this->contentFilter->getTemplateName($this->request, $this->path), "act/test/bar.tpl");
    }

    public function testSectionMapperFalse()
    {
        $this->request->expectCallCount('getSection', 2);
        $this->request->setReturnValue('getSection', '__not_exists__');
        $this->request->expectCallCount('getAction', 2);
        $this->request->setReturnValue('getAction', '__not_exists__');

        try {
            $this->contentFilter->getTemplateName($this->request, $this->path);
            $this->fail('Не было брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/Не найден активный шаблон/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }

        $this->request->setReturnValue('getSection', 'test');

        try {
            $this->contentFilter->getTemplateName($this->request, $this->path);
            $this->fail('Не было брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/Не найден активный шаблон/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

}

?>