<?php

fileLoader::load('page');
fileLoader::load('page/mappers/pageMapper');

Mock::generate('pageMapper');

class pageTest extends unitTestCase
{
    private $page;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ( 'name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'title' => array ( 'name' => 'title', 'accessor' => 'getTitle', 'mutator' => 'setTitle'),
        'content' => array ('name' => 'content', 'accessor' => 'getContent', 'mutator' => 'setContent')
        );

        $this->page = new page($map);
        $this->mapper = new pageMapper('page');
    }

    public function testAccessorsAndMutators()
    {
        $this->page->setId($id = 1);
        $this->page->import($this->page->export());

        $this->assertEqual($id, $this->page->getId());

        $props = array('Name', 'Title', 'Content');

        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->page->$getprop());

            $val = 'foo';
            $this->page->$setprop($val);


            $this->assertNull($this->page->$getprop());

            $this->page->import($this->page->export());

            $this->assertEqual($val, $this->page->$getprop());

            $val2 = 'bar';
            $this->page->$setprop($val2);


            $this->assertEqual($val, $this->page->$getprop());

            $this->page->import($this->page->export());

            $this->assertEqual($val2, $this->page->$getprop());
        }

    }

    public function testException()
    {
        try {
            $this->page->getFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/page::getfoo/i', $e->getMessage());
        }

        try {
            $this->page->setFoo('foo');
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/page::setfoo/i', $e->getMessage());
        }
    }

    public function testIdNull()
    {
        $this->assertNull($this->page->getId());
    }

    public function testFieldsSetsOnce()
    {
        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->page->$setter($first);

            $this->mapper->save($this->page);

            $this->assertIdentical($this->page->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->page->$setter($second);

            $this->mapper->save($this->page);

            $this->assertIdentical($this->page->$getter(), $first);
        }
        // For import
        $this->page->import(array('id' => $second));
        $this->mapper->save($this->page);

        $this->assertIdentical($this->page->$getter(), $first);
    }

    public function testFieldsSetsNotOnce()
    {
        foreach(array('Name', 'Title', 'Content') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->page->$setter($first);

            $this->mapper->save($this->page);

            $this->assertIdentical($this->page->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->page->$setter($second);

            $this->mapper->save($this->page);

            $this->assertIdentical($this->page->$getter(), $second);
        }
    }
}

?>