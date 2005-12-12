<?php

fileLoader::load('news/newsActiveRecord');
fileLoader::load('news/newsTableModule');

mock::generate('newsTableModule');

class newsActiveRecordTest extends unitTestCase
{
    protected $newsAR;
    public function setUp()
    {
        $TM = new mocknewsTableModule();
        $this->newsAR = new newsActiveRecord($stmt, $TM);
    }
    
    public function testFirst()
    {
        
    }
}

?>