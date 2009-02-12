<?php

fileLoader::load('orm/mapper');
fileLoader::load('cases/orm/ormSimple');

class ormSimpleMapperWithRelation extends mapper
{
    protected $table = 'ormSimple';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'foo' => array(
            'accessor' => 'getFoo',
            'mutator' => 'setFoo'),
        'bar' => array(
            'accessor' => 'getBar',
            'mutator' => 'setBar'),
        'related' => array(
            'accessor' => 'getRelated',
            'mutator' => 'setRelated',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'ormSimpleRelatedMapper'));
}

class ormSimpleRelatedMapper extends mapper
{
    protected $table = 'ormRelated';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'baz' => array(
            'accessor' => 'getBaz',
            'mutator' => 'setBaz'),
        'related' => array(
            'accessor' => 'getRelated',
            'mutator' => 'setRelated',
            'relation' => 'many',
            'foreign_key' => 'related',
            'local_key' => 'id',
            'mapper' => 'ormSimpleMapperWithRelation'));
}

class mapperRelationsTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture;
    private $fixtureRelated;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $this->fixture = array(
            1 => array(
                'foo' => 'foo1',
                'bar' => 'bar1',
                'related' => 1),
            2 => array(
                'foo' => 'foo2',
                'bar' => 'bar2',
                'related' => 1),
            3 => array(
                'foo' => 'foo3',
                'bar' => 'bar3',
                'related' => 2));

        $this->fixtureRelated = array(
            1 => array(
                'baz' => 'baz1'),
            2 => array(
                'baz' => 'baz2'),
            3 => array(
                'baz' => 'baz3'));
    }

    public function setUp()
    {
        $this->mapper = new ormSimpleMapperWithRelation();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "(" . $id . ", '" . $data['foo'] . "', '" . $data['bar'] . "', " . $data['related'] . "), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`, `bar`, `related`) VALUES ' . $valString);

        $valString = '';
        foreach ($this->fixtureRelated as $id => $data) {
            $valString .= "(" . $id . ", '" . $data['baz'] . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormRelated` (`id`, `baz`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormRelated`');
    }

    public function testRetrieve()
    {
        $this->fixture();
        $object = $this->mapper->searchByKey(1);

        $this->assertIsA($object->getRelated(), 'ormRelated');
        $this->assertEqual($object->getRelated()->getBaz(), 'baz1');
    }

    public function testUpdateRelated()
    {
        $this->fixture();
        $object = $this->mapper->searchByKey(1);

        $relatedMapper = new ormSimpleRelatedMapper();
        $related = $relatedMapper->searchByKey(2);

        $object->setRelated($related);

        $this->mapper->save($object);

        $this->assertEqual($object->getRelated()->getId(), 2);
    }

    public function testRecursiveUpdate()
    {
        $this->fixture();
        $object = $this->mapper->searchByKey(1);
        $object->getRelated()->setBaz($data = 'new');

        $this->mapper->save($object);

        $this->assertEqual($object->getRelated()->getBaz(), $data);
    }

    public function testCreateNewNestedObject()
    {
        $this->fixture();
        $object = $this->mapper->searchByKey(1);

        $relatedMapper = new ormSimpleRelatedMapper();
        $relatedNew = $relatedMapper->create();
        $relatedNew->setBaz($data = 'data');

        $object->setRelated($relatedNew);

        $this->mapper->save($object);

        $this->assertEqual($object->getRelated()->getBaz(), $data);
    }

    public function testCreateNewThisObject()
    {
        $relatedMapper = new ormSimpleRelatedMapper();
        $relatedNew = $relatedMapper->create();
        $relatedNew->setBaz($data = 'baz');

        $object = $this->mapper->create();
        $object->setFoo('foo');
        $object->setRelated($relatedNew);

        $this->mapper->save($object);

        $this->assertEqual($object->getId(), 1);
        $this->assertEqual($object->getRelated()->getBaz(), $data);
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormRelated`'), 1);
    }

    public function testLazyOneToManyCRUD()
    {
        $this->fixture();

        $mapper = new ormSimpleRelatedMapper();
        $object = $mapper->searchByKey(1);

        $collection = $object->getRelated();
        $this->assertEqual($collection->count(), 2);
        $this->assertIsA($collection, 'collection');

        $collection->delete(1);
        $this->assertNull($collection->get(1));

        $mapper->save($object);

        $object = $mapper->searchByKey(1);
        $collection = $object->getRelated();
        $this->assertEqual($collection->count(), 1);
        $this->assertNull($collection->get(1));

        $third = $this->mapper->searchByKey(3);
        $this->assertIsA($third, 'ormSimple');

        $collection->add($third);

        $this->assertNull($collection->get(3));
        $mapper->save($object);

        $object = $mapper->searchByKey(1);
        $collection = $object->getRelated();
        $this->assertEqual($collection->count(), 2);
        $this->assertIsA($collection->get(3), 'ormSimple');
    }

    public function testNotExistRelation()
    {
        $this->fixture();
        $object = $this->mapper->searchByKey(1);

        $object->setRelated(null);

        $this->mapper->save($object);

        $object = $this->mapper->searchByKey(1);

        $this->assertNull($object->getRelated());
    }
}

?>