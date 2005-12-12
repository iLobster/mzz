<?php

fileLoader::load('news/newsActiveRecord');

class newsActiveRecordTest extends unitTestCase
{
    protected $newsAR;
    public function setUp()
    {
        $this->newsAR = new newsActiveRecord();
    }
    
    public function testX()
    {
        
    }
}

?>