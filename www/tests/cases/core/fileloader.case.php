<?php

require_once '../../system/core/fileloader.php';
require_once '../../system/resolver/fileresolvert.php';
require_once './cases/resolver/testcasefileresolver.php';

mock::generate('testCaseFileResolver');

class fileLoaderTest extends unitTestCase
{
    public $resolver;
    public function setUp()
    {
        $this->resolver = new mockTestCaseFileResolver();
        fileLoader::setResolver($this->resolver);
    }
    public function testResolving()
    {
        $this->resolver->expectOnce('resolve', array('core/fileloader'));
        $this->resolver->setReturnValue('resolve', './cases/core/fileloader.case.php');
        $this->assertEqual(realpath(fileLoader::resolve('core/fileloader')), realpath('./cases/core/fileloader.case.php'));
    }
    
    public function testLoading()
    {
        
    }
}

?>