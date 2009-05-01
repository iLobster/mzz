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
        $this->request->expectCallCount('getSection', 1);
        $this->request->setReturnValue('getSection', '__not_exists__');
        $this->request->expectCallCount('getAction', 1);
        $this->request->setReturnValue('getAction', '__not_exists__');

        $this->assertFalse($this->contentFilter->getTemplateName($this->request, $this->path));
    }

}

?>