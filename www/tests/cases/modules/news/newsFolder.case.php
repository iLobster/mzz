<?php

fileLoader::load('news/newsFolder');

class newsFolderTest extends unitTestCase
{
    private $newsFolder;

    public function setUp()
    {
        $mapper = new newsFolderMapper('news');
        $this->newsFolder = new newsFolder($mapper);
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

        $newsSubFolders = $this->newsFolder->getFolders();

        /*
        Нужен мок
        $this->assertEqual(count($newsSubFolders), 2);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            $this->assertEqual($item->getParent(), '1');
        }
        */

    }

    public function testGetItems()
    {

        $newsSubFolders = $this->newsFolder->getFolders();

        /*
        тоже нужен мок
        $this->assertEqual(count($newsSubFolders), 2);

        foreach ($newsSubFolders as $item) {
            $this->assertIsA($item, 'newsFolder');
            $this->assertEqual($item->getParent(), '1');
        }
        */

    }

    public function testIdNull()
    {
        $this->assertNull($this->newsFolder->getId());
    }

    public function testIdOneTime()
    {
        $id = 2;
        $this->newsFolder->setId($id);

        $this->assertEqual($this->newsFolder->getId(), $id);

        $id2 = 5;
        $this->assertNotEqual($id, $id2);

        $this->newsFolder->setId($id2);
        $this->assertEqual($this->newsFolder->getId(), $id);
    }
}


?>