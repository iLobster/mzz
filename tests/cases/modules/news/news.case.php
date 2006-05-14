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
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'editor' => array ( 'name' => 'editor', 'accessor' => 'getEditor', 'mutator' => 'setEditor'),
        'text' => array ('name' => 'text', 'accessor' => 'getText', 'mutator' => 'setText'),
        'folder_id' => array ('name' => 'folder_id', 'accessor' => 'getFolderId', 'mutator' => 'setFolderId'),
        'created' => array ('name' => 'created', 'accessor' => 'getCreated', 'mutator' => 'setCreated', 'once' => 'true' ),
        'updated' => array ('name' => 'updated', 'accessor' => 'getUpdated', 'mutator' => 'setUpdated', 'once' => 'true' ),
        );

        $this->news = new news($map);
        $this->mapper = new newsMapper('news');
    }

    public function testAccessorsAndMutators()
    {
        //$this->page->setId($id = 1);
        //$this->page->setName(null);
        //$this->mapper->save($this->page);

        $props = array('Title', 'Editor', 'Text');

        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->news->$getprop());

            $val = 'foo';
            $this->news->$setprop($val);


            $this->assertNull($this->news->$getprop());

            $this->mapper->save($this->news);

            $this->assertEqual($val, $this->news->$getprop());

            $val2 = 'bar';
            $this->news->$setprop($val2);


            $this->assertEqual($val, $this->news->$getprop());

            $this->mapper->save($this->news);

            $this->assertEqual($val2, $this->news->$getprop());
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

    public function testFieldsSetsOnce()
    {
        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->news->$setter($first);

            $this->mapper->save($this->news);

            $this->assertIdentical($this->news->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->news->$setter($second);

            $this->mapper->save($this->news);

            $this->assertIdentical($this->news->$getter(), $first);
        }
        // For import
        $this->news->import(array('id' => $second));
        $this->mapper->save($this->news);

        $this->assertIdentical($this->news->$getter(), $first);
    }

}


?>