<?php

fileLoader::load('orm/mapper');
fileLoader::load('cases/orm/ormSimple');

class mapperTest extends unitTestCase
{
    /**
     * @var mapper
     */
    private $mapper;
    private $db;
    private $fixture;

    public function __construct()
    {
        $this->db = fDB::factory();
        $this->cleardb();

        $this->fixture = array(
            1 => array(
                'foo' => 'foo1',
                'bar' => 'bar1'),
            2 => array(
                'foo' => 'foo2',
                'bar' => 'bar2'),
            3 => array(
                'foo' => 'foo3',
                'bar' => 'bar3'));
    }

    public function setUp()
    {
        $this->mapper = new ormSimpleMapper();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "(" . $id . ", '" . $data['foo'] . "', '" . $data['bar'] . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`, `bar`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
    }

    public function testCreating()
    {
        $new = $this->mapper->create();

        $this->assertIsA($new, 'ormSimple');
        $this->assertEqual($new->state(), entity::STATE_NEW);
    }

    public function testSearchOneSimple()
    {
        $this->fixture();

        $criteria = new criteria();
        $criteria->where('foo', 'foo1');

        $object = $this->mapper->searchOneByCriteria($criteria);

        $this->assertEqual($object->state(), entity::STATE_CLEAN);
        $this->assertEqual($object->getId(), 1);
        $this->assertEqual($object->getFoo(), 'foo1');
    }

    public function testSearchFewSimple()
    {
        $this->fixture();

        $criteria = new criteria();
        $criteria->where('id', 2, criteria::LESS_EQUAL);

        $objects = $this->mapper->searchAllByCriteria($criteria);

        $this->assertEqual(sizeof($objects), 2);
        $this->assertEqual($objects[1]->getId(), 1);
        $this->assertEqual($objects[2]->getId(), 2);
    }

    public function testCreateAndSave()
    {
        $object = $this->mapper->create();

        $object->setFoo($data = 'some data');

        $this->assertNull($object->getFoo());

        $this->mapper->save($object);

        $this->assertEqual($object->state(), entity::STATE_CLEAN);
        $this->assertEqual($object->getFoo(), $data);
        $this->assertEqual($object->getId(), 1);
    }

    public function testRetrieveAndUpdate()
    {
        $this->fixture();

        $object = $this->mapper->searchByKey(1);

        $this->assertEqual($object->getFoo(), 'foo1');
        $object->setFoo($new = 'new');
        $this->assertEqual($object->getFoo(), 'foo1');

        $this->mapper->save($object);

        $this->assertEqual($object->getFoo(), $new);
        $this->assertEqual($object->state(), entity::STATE_CLEAN);

        $collection = $this->mapper->searchByKey(array(1, 2));

        $this->assertEqual($collection->count(), 2);
        $this->assertEqual($collection->first()->getId(), 1);
        $this->assertEqual($collection->last()->getId(), 2);
    }

    public function testRetrieveAndDelete()
    {
        $this->fixture();

        $object = $this->mapper->searchByKey($id = 1);
        $this->assertEqual($object->getFoo(), 'foo1');

        $this->mapper->delete($object);

        $this->assertNull($object->getId());
        $this->assertEqual($object->state(), entity::STATE_NEW);
        $this->assertNull($this->mapper->searchByKey($id));
    }

    public function testDifferentTableAndClassname()
    {
        $mapper = new ormSimpleOtherMapper();
        $object = $mapper->create();

        $this->assertIsA($object, 'ormSimpleOther');
    }

    public function testRetrieveWithSorting()
    {
        $this->fixture();

        $mapper = new ormSimpleSortingMapper();

        $collection = $mapper->searchAll();

        $this->assertEqual($collection->first()->getFoo(), 'foo3');
        $this->assertEqual($collection->last()->getFoo(), 'foo1');
    }

    public function testDeleteFromCollection()
    {
        $this->fixture();

        $collection = $this->mapper->searchAll();

        $this->assertEqual($collection->count(), 3);

        unset($collection[2]);

        $this->assertNull($collection->get(2));
        $this->assertNull($collection[2]);

        foreach ($collection as $key => $item) {
            if ($key == 2) {
                $this->fail('Unexpected key');
            }
        }
    }

    public function testSerializeUnserialize()
    {
        $this->fixture();

        $criteria = new criteria();
        $criteria->where('foo', 'foo1');

        $object = systemToolkit::getInstance()->getMapper('test', 'ormSimple')->searchOneByCriteria($criteria);

        $object2 = unserialize(serialize($object));

        $this->assertEqual($object, $object2);
    }
}

?>