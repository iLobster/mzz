<?php

fileLoader::load('orm/mapper');
fileLoader::load('cases/orm/ormSimple');

class ormSimpleMapperWithRelationMapper extends mapper
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
            'mapper' => 'test/ormSimpleRelated'
        ),
    );
}

class ormSimpleMapperWithRelationAndLazyMapper extends ormSimpleMapperWithRelationMapper
{
    public function __construct()
    {
        $this->map['related']['options'] = array('lazy');
        parent::__construct();
    }
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
            'mapper' => 'test/ormSimpleMapperWithRelation'));
}

class ormSimpleBackedMapper extends mapper
{
    protected $table = 'ormBackRelated';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'backrelated_id' => array(
            'accessor' => 'getBackRelatedId',
            'mutator' => 'setBackRelatedId'),
        'value' => array(
            'accessor' => 'getValue',
            'mutator' => 'setValue'));
}

class ormSimpleRelatedBackMapper extends mapper
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
        'foreign' => array(
            'accessor' => 'getForeign',
            'mutator' => 'setForeign',
            'relation' => 'one',
            'foreign_key' => 'related',
            'local_key' => 'id',
            'mapper' => 'test/ormSimpleWithBackRelation'));
}

class ormSimpleWithBackRelationMapper extends mapper
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
            'mutator' => 'setRelated'),
        'backrelated' => array(
            'accessor' => 'getBackRelated',
            'mutator' => 'setBackRelated',
            'relation' => 'one',
            'foreign_key' => 'backrelated_id',
            'local_key' => 'id',
            'mapper' => 'test/ormSimpleBacked'
        )
    );
}

class ormSimpleMapperWithInnerJoinRelation extends mapper
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
            'mapper' => 'test/ormSimpleRelated',
            'join_type' => 'inner'
        ),
    );
}

class mapperRelationsTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture;
    private $fixtureRelated;
    private $fixtureBackRelated;

    public function __construct()
    {
        $this->db = fDB::factory();
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

        $this->fixtureBackRelated = array(
            1 => array(
                'value' => 'val1',
                'backrelated_id' => 1),
            2 => array(
                'value' => 'val2',
                'backrelated_id' => 2),
            3 => array(
                'value' => 'val3',
                'backrelated_id' => 3));
    }

    public function setUp()
    {
        $this->mapper = new ormSimpleMapperWithRelationMapper();
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

        $valString = '';
        foreach ($this->fixtureBackRelated as $id => $data) {
            $valString .= "(" . $id . ", '" . $data['backrelated_id'] . "', '" . $data['value'] . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormBackRelated` (`id`, `backrelated_id`, `value`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormRelated`');
        $this->db->query('TRUNCATE TABLE `ormBackRelated`');
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

    public function testBack()
    {
        $this->fixture();

        $mapper = new ormSimpleRelatedBackMapper();
        $object = $mapper->searchByKey(2);

        $this->assertIsA($object->getForeign(), 'ormSimple');
        $this->assertEqual($object->getForeign()->getFoo(), 'foo3');

        $mapper2 = new ormSimpleMapper();
        $related = $mapper2->searchByKey(3);
        $this->assertEqual($related->getFoo(), 'foo3');

        $object = $mapper->create();
        $object->setBaz('new');

        try {
            $object->setForeign($related);
            $this->fail('Exception expected');
        } catch (mzzRuntimeException $e) {
        }

        $mapper->save($object);

        $object->setForeign($related);
        $mapper->save($object);

        $this->assertIsA($object->getForeign(), 'ormSimple');
        $this->assertEqual($object->getForeign()->getFoo(), 'foo3');
        $this->assertEqual($object->getForeign()->getRelated(), 4);
    }

    public function testLazyBack()
    {
        $this->fixture();

        $mapper = new ormSimpleRelatedBackMapper();
        $object = $mapper->searchByKey(2);

        $this->assertIsA($object->getForeign()->getBackRelated(), 'ormBackRelated');
        $this->assertEqual($object->getForeign()->getBackRelated()->getValue(), 'val3');
    }

    public function testGetNotExistsRelated()
    {
        $this->fixture[4] = array(
            'foo' => 'foo4',
            'bar' => 'bar4',
            'related' => 999
        );

        $this->fixture();
        $objects = $this->mapper->searchAll();

        $this->assertEqual($objects->count(), 4);

        $innerJoinMapper = new ormSimpleMapperWithInnerJoinRelation;
        $objects = $innerJoinMapper->searchAll();
        $this->assertEqual($objects->count(), 3);
    }

    public function testLazyOption()
    {
        $this->fixture();

        $collection = $this->mapper->searchAll();

        $this->db->query('UPDATE `ormRelated` SET `baz` = "foo" WHERE `id` = 1');
        $related = $collection[1]->getRelated();

        // when lazy load don't specified - update doesn't affected. because data already fetched before update
        $this->assertEqual($related->getBaz(), 'baz1');

        $mapper = new ormSimpleMapperWithRelationAndLazyMapper();
        $collectionWithLazy = $mapper->searchAll();

        $this->db->query('UPDATE `ormRelated` SET `baz` = "bar" WHERE `id` = 1');
        $related = $collectionWithLazy[1]->getRelated();

        // with lazy load update affects to result. because data loaded after updating with lazy query
        $this->assertEqual($related->getBaz(), 'bar');
    }
}

?>