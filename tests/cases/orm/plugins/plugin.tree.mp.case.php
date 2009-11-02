<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/plugins/tree_mpPlugin');
fileLoader::load('cases/orm/ormSimple');

class parentTreeTestMapper extends mapper
{
    protected $table = 'ormSimpleRelated';

    protected $map = array(
        'simple_id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'related_id' => array(
            'accessor' => 'getRelated',
            'mutator' => 'setRelated',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'test/ormSimpleChild'),
        'related_id2' => array(
            'accessor' => 'getRelated2',
            'mutator' => 'setRelated2',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'test/ormSimpleChild'));
}

class ormSimpleChildMapper extends mapper
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
            'mutator' => 'setBar'));

    public function __construct()
    {
        parent::__construct();

        $this->attach(new tree_mpPlugin(array(
            'path_name' => 'foo')));
    }
}

class ormSimpleRelated extends entity
{
}

class pluginTreeMPTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture_tree;

    public function __construct()
    {
        $this->db = fDB::factory();
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
                'path' => '1/'),
            2 => array(
                'path' => '1/2/'),
            3 => array(
                'path' => '1/3/'),
            4 => array(
                'path' => '1/4/'),
            5 => array(
                'path' => '1/2/5/'),
            6 => array(
                'path' => '1/2/6/'),
            7 => array(
                'path' => '1/3/7/'),
            8 => array(
                'path' => '1/3/8/'));
    }

    public function setUp()
    {
        $this->fixture();
        $this->mapper = new ormSimpleMapper();
        $observer = new tree_mpPlugin(array(
            'path_name' => 'foo'));
        $this->mapper->attach($observer, 'tree_mp');
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
            $valString .= "(" . $id . ", '" . $data['path'] . "', '" . 'foo' . substr(str_replace('/', '/foo', $data['path']), 0, -3) . "', " . $id . ", " . substr_count($data['path'], '/') . "), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple_tree` (`id`, `spath`, `path`, `foreign_key`, `level`) VALUES ' . $valString);

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
        $this->db->query('TRUNCATE TABLE `ormSimple_tree`');
        $this->db->query('TRUNCATE TABLE `ormSimpleRelated`');
    }

    public function testRetrieve()
    {
        $object = $this->mapper->searchByKey(1);

        $this->assertEqual($object->getTreeSPath(), '1/');
        $this->assertEqual($object->getTreePath(), 'foo1');
        $this->assertEqual($object->getTreeLevel(), 1);
        $this->assertEqual($object->getFoo(), 'foo1');

        $object = $this->mapper->searchByKey(6);

        $this->assertEqual($object->getTreeSPath(), '1/2/6/');
        $this->assertEqual($object->getTreePath(), 'foo1/foo2/foo6');
        $this->assertEqual($object->getTreeLevel(), 3);
        $this->assertEqual($object->getFoo(), 'foo6');
    }

    public function testRetrieveParent()
    {
        $object = $this->mapper->searchByKey(6);
        $parent = $object->getTreeParent();

        $this->assertEqual($parent->getId(), 2);
        $this->assertEqual($parent->getTreeSPath(), '1/2/');
        $this->assertEqual($parent->getTreePath(), 'foo1/foo2');
        $this->assertEqual($parent->getTreeLevel(), '2');
    }

    public function testCreateNewAsRoot()
    {
        $object = $this->mapper->create();
        $object->setFoo('new');
        $this->mapper->save($object);

        $this->assertEqual($object->getTreeLevel(), 1);
        $this->assertEqual($object->getTreeSPath(), sizeof($this->fixture_tree) + 1);
        $this->assertEqual($object->getTreePath(), 'new');
    }

    public function testCreateAsSubnode()
    {
        $object = $this->mapper->create();
        $object->setFoo('new');

        $parent = $this->mapper->searchByKey(5);
        $object->setTreeParent($parent);

        $this->mapper->save($object);

        $this->assertEqual($object->getTreeSPath(), '1/2/5/9/');
        $this->assertEqual($object->getTreePath(), 'foo1/foo2/foo5/new');
        $this->assertEqual($object->getTreeLevel(), 4);

        $this->assertEqual($object->getTreeParent()->getId(), 5);
    }

    public function testMoveNode()
    {
        $newParent = $this->mapper->searchByKey(1);

        $object = $this->mapper->searchByKey(5);
        $object->setTreeParent($newParent);

        $this->mapper->save($object);

        $this->assertEqual($object->getTreeSPath(), '1/5/');
        $this->assertEqual($object->getTreePath(), 'foo1/foo5');
        $this->assertEqual($object->getTreeLevel(), 2);
        $this->assertEqual($object->getTreeParent()->getId(), 1);
    }

    public function testMoveNodeWithSubnodes()
    {
        $newParent = $this->mapper->searchByKey(4);

        $object = $this->mapper->searchByKey(2);
        $object->setTreeParent($newParent);

        $this->mapper->save($object);

        $this->assertEqual($object->getTreeSPath(), '1/4/2/');
        $this->assertEqual($object->getTreePath(), 'foo1/foo4/foo2');
        $this->assertEqual($object->getTreeLevel(), 3);
        $this->assertEqual($object->getTreeParent()->getId(), 4);

        $object = $this->mapper->searchByKey(5);
        $this->assertEqual($object->getTreeSPath(), '1/4/2/5/');
        $this->assertEqual($object->getTreePath(), 'foo1/foo4/foo2/foo5');
        $this->assertEqual($object->getTreeLevel(), 4);
        $this->assertEqual($object->getTreeParent()->getId(), 2);
    }

    public function testEditPathProperty()
    {
        $object = $this->mapper->searchByKey(2);

        $object->setFoo('new_foo');
        $this->mapper->save($object);

        $object = $this->mapper->searchByKey(5);
        $this->assertEqual($object->getTreePath(), 'foo1/new_foo/foo5');
    }

    public function testEditRootPathProperty()
    {
        $object = $this->mapper->searchByKey(1);
        $object->setFoo('new_foo');

        $this->mapper->save($object);

        $object = $this->mapper->searchByKey(5);
        $this->assertEqual($object->getTreePath(), 'new_foo/foo2/foo5');
    }

    public function testDelete()
    {
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple`'), 8);

        $object = $this->mapper->searchByKey(2);
        $this->mapper->delete($object);

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple`'), 5);
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple_tree`'), 5);
    }

    public function testParentBranch()
    {
        $object = $this->mapper->searchByKey(6);

        $result = $object->getTreeParentBranch();

        $this->assertIsA($result, 'collection');
        $this->assertEqual($result->count(), 3);
        $this->assertEqual($result->first()->getId(), 1);
        $this->assertEqual($result->next()->getId(), 2);
        $this->assertEqual($result->next()->getId(), 6);
    }

    public function testGetBranch()
    {
        $object = $this->mapper->searchByKey(2);

        $result = $object->getTreeBranch();

        $this->assertIsA($result, 'collection');
        $this->assertEqual($result->count(), 3);
        $this->assertEqual($result->first()->getId(), 2);
        $this->assertEqual($result->next()->getId(), 5);
        $this->assertEqual($result->next()->getId(), 6);

        $object = $this->mapper->searchByKey(1);

        $result = $object->getTreeBranch(1);

        $this->assertEqual($result->count(), 4);
        $this->assertEqual($result->first()->getId(), 1);
        $this->assertEqual($result->next()->getId(), 2);
        $this->assertEqual($result->next()->getId(), 3);
        $this->assertEqual($result->next()->getId(), 4);
    }

    public function testGetBranchWithSort()
    {
        $object = $this->mapper->searchByKey(1);

        $criteria = new criteria();
        $criteria->orderByDesc('foo');

        $result = $object->getTreeBranch(0, $criteria);

        $this->assertEqual($result->count(), 8);
        $this->assertEqual($result->first()->getId(), 1);
        $this->assertEqual($result->next()->getId(), 4);
        $this->assertEqual($result->next()->getId(), 3);
        $this->assertEqual($result->next()->getId(), 8);
        $this->assertEqual($result->next()->getId(), 7);
        $this->assertEqual($result->next()->getId(), 2);
        $this->assertEqual($result->next()->getId(), 6);
        $this->assertEqual($result->next()->getId(), 5);
    }

    public function testGetTreeWithoutRoot()
    {
        $criteria = new criteria();
        $criteria->where('id', 1, criteria::NOT_EQUAL);
        $criteria->where('tree.level', 2);

        $collection = $this->mapper->searchAllByCriteria($criteria);

        $this->assertEqual($collection->count(), 3);
        $this->assertEqual($collection->first()->getId(), 2);
        $this->assertEqual($collection->next()->getId(), 3);
        $this->assertEqual($collection->next()->getId(), 4);
    }

    public function testGetBranchByPath()
    {
        $branch = $this->mapper->plugin('tree_mp')->getBranchByPath('foo1/foo2/');

        $this->assertEqual($branch->count(), 3);
        $this->assertEqual($branch->keys(), array(
            2,
            5,
            6));
    }

    public function testFewRelatedNodes()
    {
        $mapper = new parentTreeTestMapper();
        $parentObject = $mapper->searchByKey(6);

        $object = $parentObject->getRelated();
        $object2 = $parentObject->getRelated2();

        $this->assertIsA($object2, 'ormSimple');
        $this->assertEqual($object2->getTreeSPath(), '1/3/7/');
        $this->assertEqual($object2->getTreePath(), 'foo1/foo3/foo7');
        $this->assertEqual($object2->getTreeParentBranch()->count(), 3);
    }
}

?>