<?php

fileLoader::load('orm/plugins/identityMapPlugin');
fileLoader::load('cases/orm/ormSimple');

class identityMapPluginTest extends unitTestCase
{
    /**
     * @var mapper
     */
    private $mapper;

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
        $this->fixture();

        $this->mapper = new ormSimpleMapper();
        $this->mapper->plugins('identityMap');
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

    public function testIdentityMapSimpleMultipleRetrieveByKey()
    {
        $object1 = $this->mapper->searchByKey(1);
        $object2 = $this->mapper->searchByKey(1);

        $this->assertTrue($object1 === $object2);
    }

    public function testIdentityMapSimpleRetrieveWithAnotherField()
    {
        $collection = $this->mapper->searchAllByField('foo', 'foo1');
        $object = $this->mapper->searchByKey(1);

        $this->assertTrue($object === $collection[1]);
    }

    public function testDelayLoad()
    {
        $this->mapper->plugin('identityMap')->delay('id', 1);
        $this->mapper->plugin('identityMap')->delay('id', 2);
        $this->mapper->plugin('identityMap')->delay('id', 3);

        $count = $this->db->getQueriesNum();

        $this->mapper->searchByKey(1);
        $this->mapper->searchByKey(2);
        $this->mapper->searchByKey(3);

        $this->assertEqual($count + 1, $this->db->getQueriesNum());
    }

    public function testUpdate()
    {
        $object = $this->mapper->searchByKey(1);

        $this->assertEqual($object->getFoo(), 'foo1');

        $object->setFoo($new = 'new foo');
        $this->mapper->save($object);

        $this->assertEqual($object->getFoo(), $new);
    }
}

?>