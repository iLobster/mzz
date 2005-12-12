<?php

fileLoader::load('news/newsActiveRecord');
fileLoader::load('news/newsTableModule');
fileLoader::load('db/dbFactory');
fileLoader::load('core/registry');

mock::generate('newsTableModule');

class newsActiveRecordTest extends unitTestCase
{
    protected $newsAR;
    public function setUp()
    {
        $registry = Registry::instance();
        $registry->setEntry('config', 'config');
        $db = Db::factory();
        $TM = new mocknewsTableModule();
        $this->newsAR = new newsActiveRecord($stmt, $TM);
    }
    
    public function testFirst()
    {

    }
}

?>