<?php

fileLoader::load('orm/mapper');
fileLoader::load('cases/orm/ormSimple');

class leftMapper extends mapper
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
        'right' => array(
            'accessor' => 'getRight',
            'mutator' => 'setRight',
            'relation' => 'many-to-many',
            'mapper' => 'test/right',
            'reference' => 'ormSimpleRelated',
            'local_key' => 'id',
            'foreign_key' => 'id',
            'ref_local_key' => 'simple_id',
            'ref_foreign_key' => 'related_id'));
}

class rightMapper extends mapper
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
            'mutator' => 'setBaz'));
}

class mapperManyToManyRelationsTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture = array(
        array(
            1,
            1),
        array(
            1,
            2),
        array(
            1,
            3),
        array(
            2,
            5));

    public function __construct()
    {
        $this->db = fDB::factory();
        $this->cleardb();
    }

    public function setUp()
    {
        $this->mapper = new leftMapper();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        for ($i = 1; $i <= 5; $i++) {
            $valString .= "(" . $i . ", 'foo" . $i . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`) VALUES ' . $valString);

        $valString = '';
        for ($i = 1; $i <= 5; $i++) {
            $valString .= "(" . $i . ", 'baz" . $i . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormRelated` (`id`, `baz`) VALUES ' . $valString);

        $valString = '';
        foreach ($this->fixture as $data) {
            $valString .= "(" . $data[0] . ", " . $data[1] . "), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimpleRelated` (`simple_id`, `related_id`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormRelated`');
        $this->db->query('TRUNCATE TABLE `ormSimpleRelated`');
    }

    public function testRetrieve()
    {
        $this->fixture();

        $object = $this->mapper->searchByKey(1);

        $collection = $object->getRight();

        $this->assertEqual($collection->count(), 3);
        $this->assertIsA($collection, 'collection');

        $this->assertEqual($collection->first()->getId(), 1);
        $this->assertEqual($collection->last()->getId(), 3);

        $collection->delete(1);

        $this->mapper->save($object);

        $object = $this->mapper->searchByKey(1);
        $collection = $object->getRight();
        $this->assertEqual($collection->count(), 2);
        $this->assertNull($collection->get(1));

        $rightMapper = new rightMapper();
        $fourth = $rightMapper->searchByKey(4);

        $this->assertEqual($fourth->getId(), 4);

        $collection->add($fourth);

        $this->mapper->save($object);

        $object = $this->mapper->searchByKey(1);
        $collection = $object->getRight();
        $this->assertEqual($collection->count(), 3);
        $this->assertEqual($collection->get(4)->getBaz(), 'baz4');
    }

    public function testDeleteRecordsFromRelationsTable()
    {
        $this->fixture();

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimpleRelated`'), 4);

        $object = $this->mapper->searchByKey(1);
        $this->mapper->delete($object);

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimpleRelated`'), 1);
    }
}

?>