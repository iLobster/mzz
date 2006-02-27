<?php

fileLoader::load('news');
fileLoader::load('news/mappers/newsMapper');

Mock::generate('newsMapper');

class newsTest extends unitTestCase
{
    private $news;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId')
        );

        $this->news = new news($map);
    }

    public function testAccessorsAndMutators()
    {
        $props = array('Title', 'Text', 'FolderId');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->news->$getprop());

            $val = 'foo';
            $this->news->$setprop($val);

            $this->assertEqual($val, $this->news->$getprop());

            $val2 = 'bar';
            $this->news->$setprop($val2);

            $this->assertEqual($val2, $this->news->$getprop());
            $this->assertNotEqual($val, $this->news->$getprop());
        }
    }

    public function testException()
    {
        try {
            $this->news->getFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/news::getfoo/i', $e->getMessage());
        }

        try {
            $this->news->setFoo('foo');
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/news::setfoo/i', $e->getMessage());
        }
    }

    public function testIdNull()
    {
        $this->assertNull($this->news->getId());
    }

    public function testIdOneTime()
    {
        $id = '2';
        $this->news->setId($id);

        $this->assertIdentical($this->news->getId(), $id);

        $id2 = '5';
        $this->assertNotEqual($id, $id2);

        $this->news->setId($id2);
        $this->assertIdentical($this->news->getId(), $id);
    }
}


?>