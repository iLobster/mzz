<?php

fileLoader::load('news/newsTableModule');

class newsTableModuleTest extends unitTestCase
{
    protected $newsTM;
    public function setUp()
    {
        $this->newsTM = new newsTableModule();
    }
    
    public function testGetNews()
    {
        
    }
}

?>