<?php

fileLoader::load('acl');
fileLoader::load('user');

class userMapperStub extends mapper
{
    protected $table = '';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'options' => array(
                'pk')));
}

class userStub extends user
{
    private $id;
    function __construct($id = 1)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function getGroups()
    {
        return new collection(array(
            1 => 'foo',
            2 => 'bar'), new userMapperStub());
        return array(
            1,
            2);
    }
}

class aclTest extends unitTestCase
{
    private $db;
    private $acl;
    private $alias;

    public function __construct()
    {
        $this->db = db::factory();
    }

    public function setUp()
    {
        $this->clearDb();
        $this->db->query("INSERT INTO `sys_access` (`id`, `action_id`, `class_section_id`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES
        (1,1,1,1,NULL,1,0,1), (2,2,1,1,NULL,1,0,1), (3,1,1,NULL,1,0,1,1),
        (4,1,1,3,NULL,1,0,0), (5,2,1,3,NULL,1,0,0), (6,2,1,NULL,4,1,0,0),
        (7,1,1,0,NULL,1,0,0), (8,2,1,0,NULL,1,0,0)");

        $this->db->query("INSERT INTO `sys_classes` (`id`, `name`, `module_id`) VALUES (1, 'news', 1)");
        $this->db->query("INSERT INTO `sys_sections` (`id`, `name`) VALUES (1, 'news')");
        $this->db->query("INSERT INTO `sys_classes_sections` (`id`, `class_id`, `section_id`) VALUES (1,1,1)");
        $this->db->query("INSERT INTO `sys_classes_actions` (`id`, `class_id`, `action_id`) VALUES (1,1,1), (2,1,2)");
        $this->db->query("INSERT INTO `sys_actions` (`id`, `name`) VALUES (1,'edit'), (2,'delete')");
        $this->db->query("INSERT INTO `sys_access_registry` (`obj_id`, `class_section_id`) VALUES (1, 1)");

        $this->acl = new acl($user = new userStub(), $object_id = 1, $class = null, $section = null, $alias = $this->alias);
    }

    public function tearDown()
    {
        $this->clearDb();
    }

    public function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_access`');
        $this->db->query('TRUNCATE TABLE `sys_classes`');
        $this->db->query('TRUNCATE TABLE `sys_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_sections`');
        $this->db->query('TRUNCATE TABLE `sys_classes_actions`');
        $this->db->query('TRUNCATE TABLE `sys_actions`');
        $this->db->query('TRUNCATE TABLE `sys_access_registry`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `user_group`');
    }

    public function testGetAccessAll()
    {
        $this->assertEqual($this->acl->get(), array(
            'edit' => 0,
            'delete' => 1));
    }

    public function testGetAccessPartial()
    {
        $acl = new acl($user = new userStub(), $object_id = 1, $class = null, $section = null, $alias = $this->alias);
        $this->assertEqual($acl->get('edit'), 0);
        $this->assertEqual($acl->get('delete'), 1);
    }

    public function testGetAccessPartialNotExists()
    {
        $this->assertEqual($this->acl->get('somenotexistparam'), 0);
    }

    public function testGetForGroups()
    {
        $this->assertEqual($this->acl->getForGroup(1), array(
            'edit' => 0));
    }

    public function testRegister()
    {
        $acl = new acl(new userStub(2), 0, null, null, $this->alias);
        $acl->register($obj_id = 10, $class = 'news', $section = 'news');

        $this->assertEqual(1, $acl->get('delete'));
        $this->assertEqual(1, $acl->get('edit'));

        $acl2 = new acl(new userStub(3), 10, null, null, $this->alias);
        $this->assertEqual(1, $acl2->get('delete'));
        $this->assertEqual(1, $acl2->get('edit'));

        $this->assertEqual(1, $this->db->getOne('SELECT COUNT(*) FROM `sys_access_registry` WHERE `obj_id` = 10 AND `class_section_id` = 1'));

        $this->assertTrue($acl->isRegistered($obj_id));
        $this->assertFalse($acl->isRegistered(666));
    }

    public function testExceptionOnNotUser()
    {
        $this->db->query("INSERT INTO `user_user` (`id`, `login`) VALUES (1, 'Guest')");
        try {
            $acl = new acl('news', 'news', 'foo');
            $this->fail('Не было брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->assertPattern('/объект не является инстанцией класса user/', $e->getMessage());
            $this->pass();
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testDeleteNoArg()
    {
        $this->acl->delete();
        $stmt = $this->db->query('SELECT COUNT(*) AS `cnt` FROM `sys_access` WHERE `class_section_id` IN (1, 2) AND `obj_id` = 1');
        $row = $stmt->fetch();
        $this->assertEqual($row['cnt'], 0);
    }

    public function testDeleteArg()
    {
        $acl = new acl(new userStub(2), 0, null, null, $this->alias);
        $acl->delete(1);
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) AS `cnt` FROM `sys_access` WHERE `class_section_id` IN (1, 2) AND `obj_id` = 1'), 0);
        $this->assertEqual(0, $this->db->getOne('SELECT COUNT(*) FROM `sys_access_registry` WHERE `obj_id` = 10 AND `class_section_id` = 1'));
    }

    public function testSet()
    {
        $this->db->query('DELETE FROM `sys_access` WHERE `id` = 3');
        $this->db->query('UPDATE `sys_access` SET `allow` = 0 WHERE `id` = 1');

        $acl = new acl(new userStub(), 1, 'news', 'news', $this->alias);

        $this->assertEqual($acl->get('edit'), 0);
        $acl->set('edit', 1);
        $this->assertEqual($acl->get('edit'), 1);

        $this->assertEqual($acl->get('delete'), 1);
        $acl->set('delete', 0);
        $this->assertEqual($acl->get('delete'), 0);

        $this->assertEqual($acl->get('edit'), 1);
        $acl->set('edit', array(
            'allow' => 1,
            'deny' => 0));
        $this->assertEqual($acl->get('edit'), 1);

        $this->assertEqual($acl->get('edit'), 1);
        $acl->set('edit', array(
            'allow' => 0,
            'deny' => 0));
        $this->assertEqual($acl->get('edit'), 0);

        $this->assertEqual($acl->get('edit'), 0);
        $acl->set('edit', array(
            'allow' => 0,
            'deny' => 1));
        $this->assertEqual($acl->get('edit'), 0);

        $this->assertEqual($acl->get('edit'), 0);
        $acl->set('edit', array(
            'allow' => 1,
            'deny' => 1));
        $this->assertEqual($acl->get('edit'), 0);
    }

    public function testSetArray()
    {
        $this->db->query('DELETE FROM `sys_access` WHERE `id` = 3');
        $this->db->query('UPDATE `sys_access` SET `allow` = 0 WHERE `id` = 1');

        $acl = new acl(new userStub(), 1, 'news', 'news', $this->alias);

        $cache = systemToolkit::getInstance()->getCache();
        $cache->flush();

        $this->assertEqual($acl->get('edit'), 0);
        $this->assertEqual($acl->get('delete'), 1);

        $acl->set($access = array(
            'edit' => 0,
            'delete' => 0));

        $this->assertEqual($acl->get(), $access);
    }

    public function testSetInvalid()
    {
        try {
            $this->acl->set('foo', 1);
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern("/объекта 1 нет изменяемого действия 'foo'/", $e->getMessage());
            $this->pass();
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testSetUnregistered()
    {
        try {
            $acl = new acl(new userStub(), 666, 'news', 'news', $this->alias);
            $acl->set('foo', 1);
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertEqual('Объект с идентификатором 666 не зарегистрирован в acl', $e->getMessage());
            $this->pass();
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testGetUsersList()
    {
        $this->db->query("INSERT INTO `user_user` (`id`, `login`) VALUES (1, 'Guest')");
        $users = $this->acl->getUsersList();

        $this->assertEqual(sizeof($users), 1);
        $this->assertEqual($users[1]->getLogin(), 'Guest');
    }

    public function testGetGroupsList()
    {
        $this->db->query("INSERT INTO `user_group` (`id`, `name`) VALUES (1, 'somegroup')");
        $groups = $this->acl->getGroupsList();

        $this->assertEqual(sizeof($groups), 1);
        $this->assertEqual($groups[1]->getName(), 'somegroup');
    }

    public function testGetClass()
    {
        $this->assertEqual($this->acl->getClass(), 'news');
    }

    public function testDeleteUser()
    {
        $this->assertEqual(2, $this->db->getOne('SELECT COUNT(*) FROM `sys_access` WHERE `uid` = 1'));
        $this->acl->deleteUser(1);
        $this->assertEqual(0, $this->db->getOne('SELECT COUNT(*) FROM `sys_access` WHERE `uid` = 1'));
    }

    public function testDeleteGroup()
    {
        $this->assertEqual(1, $this->db->getOne('SELECT COUNT(*) FROM `sys_access` WHERE `gid` = 1'));
        $this->acl->deleteGroup(1);
        $this->assertEqual(0, $this->db->getOne('SELECT COUNT(*) FROM `sys_access` WHERE `gid` = 1'));
    }
}

?>