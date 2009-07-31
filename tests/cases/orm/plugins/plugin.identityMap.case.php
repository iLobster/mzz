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
        $this->db = DB::factory();
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
}

?>