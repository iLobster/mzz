<?php

fileLoader::load('news/newsFolder');
fileLoader::load('news/mappers/newsFolderMapper');

mock::generate('newsFolderMapper');

class newsFolderTest extends unitTestCase
{
    private $newsFolder;
    private $mapper;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ('name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'parent' => array ('name' => 'parent', 'accessor' => 'getParent', 'mutator' => 'setParent')
        );

        $this->mapper = new mocknewsFolderMapper('news');
        $this->newsFolder = new newsFolder($this->mapper, $map);
    }

    public function testAccessorsAndMutators()
    {
        $props = array('Name', 'Parent');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->newsFolder->$getprop());

            $val = 'foo';
            $this->newsFolder->$setprop($val);

            $this->assertEqual($val, $this->newsFolder->$getprop());

            $val2 = 'bar';
            $this->newsFolder->$setprop($val2);

            $this->assertEqual($val2, $this->newsFolder->$getprop());
            $this->assertNotEqual($val, $this->newsFolder->$getprop());
        }
    }

    public function testException()
    {
        try {
            $this->newsFolder->getFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/newsFolder::getfoo/i', $e->getMessage());
        }

        try {
            $this->newsFolder->setFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/newsFolder::setfoo/i', $e->getMessage());
        }
    }


    public function testGetFolders()
    {
        $id = 666;
        $this->newsFolder->setId($id);

        $this->mapper->expectOnce('getFolders', array($id));
        $this->mapper->setReturnValue('getFolders', array('foo', 'bar'));

        $this->assertEqual($this->newsFolder->getFolders(), array('foo', 'bar'));
    }

    public function testGetItems()
    {
        $id = 666;
        $this->newsFolder->setId($id);

        $this->mapper->expectOnce('getItems', array($id));
        $this->mapper->setReturnValue('getItems', array('foo', 'bar'));

        $this->assertEqual($this->newsFolder->getItems(), array('foo', 'bar'));
    }

    public function testIdNull()
    {
        $this->assertNull($this->newsFolder->getId());
    }

    public function testFieldsSetsOnce()
    {
        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->newsFolder->$setter($first);

            $this->assertIdentical($this->newsFolder->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->newsFolder->$setter($second);
            $this->assertIdentical($this->newsFolder->$getter(), $first);
        }
    }
}


?>