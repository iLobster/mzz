<?php

fileLoader::load('news/newsFolder');
fileLoader::load('news/mappers/newsFolderMapper');

mock::generate('newsFolderMapper');

class newsFolderTest extends unitTestCase
{
    private $newsFolder;
    private $mapper;
    private $db;

    public function setUp()
    {
        $map = array(
        'id' => array ('name' => 'id', 'accessor' => 'getId', 'mutator' => 'setId', 'once' => 'true' ),
        'name' => array ('name' => 'name', 'accessor' => 'getName', 'mutator' => 'setName'),
        'parent' => array ('name' => 'parent', 'accessor' => 'getParent', 'mutator' => 'setParent'),
        'obj_id' => array('name' => 'obj_id', 'accessor' => 'getObjId', 'mutator' => 'setObjId', 'once' => 'true')
        );

        $this->db = DB::factory();
        $this->mappermock = new mocknewsFolderMapper('news');
        $this->mapper = new newsFolderMapper('news');
        $this->newsFolder = new newsFolder($this->mappermock, $map);
        $this->cleardb();

        $this->db->query("INSERT INTO `user_user` (`login`) VALUES ('GUEST')");
        $this->db->query("INSERT INTO `sys_classes` (`name`, `module_id`) VALUES ('news', 1), ('newsFolder', 1)");
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `news_news`');
        $this->db->query('TRUNCATE TABLE `news_newsFolder`');
        $this->db->query('TRUNCATE TABLE `news_newsFolder_tree`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
        $this->db->query('TRUNCATE TABLE `sys_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_registry`');
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    public function testAccessorsAndMutators()
    {
        $this->newsFolder->setId($id = 1);
        $this->newsFolder->import($this->newsFolder->export());

        $this->newsFolder->import($this->newsFolder->export());

        $props = array('Name', 'Parent');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($this->newsFolder->$getprop());

            $val = 'foo';
            $this->newsFolder->$setprop($val);


            $this->assertNull($this->newsFolder->$getprop());

            $this->newsFolder->import($this->newsFolder->export());

            $this->assertEqual($val, $this->newsFolder->$getprop());

            $val2 = 'bar';
            $this->newsFolder->$setprop($val2);


            $this->assertEqual($val, $this->newsFolder->$getprop());

            $this->newsFolder->import($this->newsFolder->export());

            $this->assertEqual($val2, $this->newsFolder->$getprop());
        }
    }

    public function testException()
    {
        try {
            $this->newsFolder->getFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertPattern('/newsFolder::getfoo/i', $e->getMessage());
        }

        try {
            $this->newsFolder->setFoo();
            $this->fail('Должен быть брошен EXCEPTION!');
        } catch (Exception $e) {
            $this->assertPattern('/newsFolder::setfoo/i', $e->getMessage());
        }
    }

    public function testGetFolders()
    {
        $id = 666;
        $this->newsFolder->setParent($id);

        $this->mappermock->expectOnce('getFolders', array($id, '*'));
        $this->mappermock->setReturnValue('getFolders', array('foo', 'bar'));
        $this->newsFolder->import($this->newsFolder->export());

        $this->assertEqual($this->newsFolder->getFolders(), array('bar'));
    }

    public function testGetItems()
    {
        $id = 666;
        $this->newsFolder->setId($id);

        $this->mappermock->expectOnce('getItems', array($id));
        $this->mappermock->setReturnValue('getItems', array('foo', 'bar'));
        $this->newsFolder->import($this->newsFolder->export());

        $this->assertEqual($this->newsFolder->getItems(), array('foo', 'bar'));
    }

    public function testIdNull()
    {
        $this->assertNull($this->newsFolder->getId());
    }

    public function testFieldsSetsOnce()
    {
        $this->db->query("INSERT INTO `news_newsFolder` (`id`, `name`, `parent`, `path`) VALUES (1, 'root', 1, 'root')");
        $this->db->query("INSERT INTO `news_newsFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES (1, 1, 2, 1)");
        $target = $this->mapper->searchOneByField('id', 1);

        foreach(array('Id') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->newsFolder->$setter($first);

            $this->mapper->save($this->newsFolder, $target);

            $this->assertIdentical($this->newsFolder->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            try {
                $this->newsFolder->$setter($second);
                $this->fail('Ожидается исключение');
            } catch (mzzRuntimeException $e) {
                $this->pass();
            }

            $this->mapper->save($this->newsFolder);

            $this->assertIdentical($this->newsFolder->$getter(), $first);
        }
        // For import
        $this->newsFolder->import(array('id' => $second));
        $this->mapper->save($this->newsFolder);

        $this->assertIdentical($this->newsFolder->$getter(), $first);
    }

    public function testFieldsSetsNotOnce()
    {
        $this->db->query("INSERT INTO `news_newsFolder` (`id`, `name`, `parent`, `path`) VALUES (1, 'root', 1, 'root')");
        $this->db->query("INSERT INTO `news_newsFolder_tree` (`id`, `lkey`, `rkey`, `level`) VALUES (1, 1, 2, 1)");
        $target = $this->mapper->searchOneByField('id', 1);

        foreach(array('Name') as $val) {
            $setter = 'set' . $val;
            $getter = 'get' . $val;

            $first = '2';

            $this->newsFolder->$setter($first);

            $this->mapper->save($this->newsFolder, $target);

            $this->assertIdentical($this->newsFolder->$getter(), $first);

            $second = '5';
            $this->assertNotEqual($second, $first);

            $this->newsFolder->$setter($second);

            $this->mapper->save($this->newsFolder);

            $this->assertIdentical($this->newsFolder->$getter(), $second);
        }
    }
}

?>