<?php

fileLoader::load('cases/orm/ormSimple');
fileLoader::load('orm/plugins/tree_alPlugin');

class pluginTreeALTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture_tree;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();

        #        Вот на таком дереве будем тестировать
        #
        #
        #                                   1
        #                                   |
        #                            ----------------
        #                            |      |       |
        #                            2      3       4
        #                            |      |
        #                      -------      ---------
        #                      |     |      |       |
        #                      5     6      7       8
        #


        $this->fixture_tree = array(
            1 => array(
                0,
                1,
                'path' => '1/'),
            2 => array(
                1,
                2,
                'path' => '1/2/'),
            3 => array(
                1,
                2,
                'path' => '1/3'),
            4 => array(
                1,
                2,
                'path' => '1/4'),
            5 => array(
                2,
                3,
                'path' => '1/2/5/'),
            6 => array(
                2,
                3,
                'path' => '1/2/6/'),
            7 => array(
                3,
                3,
                'path' => '1/3/7/'),
            8 => array(
                3,
                3,
                'path' => '1/3/8/'));
    }

    public function setUp()
    {
        $this->fixture();
        $this->mapper = new ormSimpleMapper();
        $observer = new tree_alPlugin(array(
            'path_name' => 'foo',
            'postfix' => 'tree_al'));
        $this->mapper->attach($observer);
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        for ($id = 1; $id <= 8; $id++) {
            $valString .= "(" . $id . ", 'foo" . $id . "', 'bar" . $id . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`, `bar`) VALUES ' . $valString);

        $valString = '';
        foreach ($this->fixture_tree as $id => $data) {
            $valString .= "(" . $id . ", " . $id . ", " . $data[0] . ", " . $data[1] . ", 'foo" . substr(str_replace('/', '/foo', $data['path']), 0, -3) . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple_tree_al` (`id`, `foreign_key`, `parent_id`, `level`, `path`) VALUES ' . $valString);

        $valString = '';
        for ($id = 1; $id <= 8; $id++) {
            $valString .= "(" . $id . ", " . $id . ", " . ($id + 1) . "), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimpleRelated` (`simple_id`, `related_id`, `related_id2`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormSimple_tree_al`');
    }

    public function testRetrieve()
    {
        $object = $this->mapper->searchByKey(1);

        $this->assertEqual($object->getTreePath(), 'foo1');
        $this->assertEqual($object->getTreeLevel(), 1);
        $this->assertEqual($object->getFoo(), 'foo1');

        $object = $this->mapper->searchByKey(6);

        $this->assertEqual($object->getTreePath(), 'foo1/foo2/foo6');
        $this->assertEqual($object->getTreeLevel(), 3);
        $this->assertEqual($object->getFoo(), 'foo6');
    }
}

?>