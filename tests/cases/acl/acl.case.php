<?php

fileLoader::load('acl');

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


    function getGroupsList()
    {
        return array(1, 2);
    }
}

class aclTest extends unitTestCase
{
    private $db;
    private $acl;

    public function __construct()
    {
        $this->db = db::factory();
    }

    public function setUp()
    {
        $this->clearDb();
        $this->db->query("INSERT INTO `sys_access` (`id`, `class_section_action`, `uid`, `gid`, `allow`, `obj_id`) VALUES (1,1,1,NULL,1,1), (2,2,1,NULL,1,1), (3,1,NULL,1,0,1)");
        $this->db->query("INSERT INTO `sys_access` (`id`, `class_section_action`, `uid`, `gid`, `allow`, `obj_id`) VALUES (4,1,3,NULL,1,0), (5,2,3,NULL,1,0), (6,2,NULL,4,1,0)");
        $this->db->query("INSERT INTO `sys_access` (`id`, `class_section_action`, `uid`, `gid`, `allow`, `obj_id`) VALUES (7,1,0,NULL,1,0), (8,2,0,NULL,1,0)");
        $this->db->query("INSERT INTO `sys_access_classes` (`id`, `name`) VALUES (1,'news')");
        $this->db->query("INSERT INTO `sys_access_sections` (`id`, `name`) VALUES (1,'news')");
        $this->db->query("INSERT INTO `sys_access_classes_sections` (`id`, `class_id`, `section_id`) VALUES (1,1,1)");
        $this->db->query("INSERT INTO `sys_access_classes_sections_actions` (`id`, `class_section_id`, `action_id`) VALUES (1,1,1), (2,1,2)");
        $this->db->query("INSERT INTO `sys_access_actions` (`id`, `name`) VALUES (1,'edit'), (2,'delete')");

        $this->acl = new acl(new userStub(), 1);
    }

    public function tearDown()
    {
        $this->clearDb();
    }

    public function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_access`');
        $this->db->query('TRUNCATE TABLE `sys_access_classes`');
        $this->db->query('TRUNCATE TABLE `sys_access_classes_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_classes_sections_actions`');
        $this->db->query('TRUNCATE TABLE `sys_access_actions`');
        $this->db->query('TRUNCATE TABLE `user_user`');
        $this->db->query('TRUNCATE TABLE `user_group`');
    }

    public function testGetAccessAll()
    {
        $this->assertEqual($this->acl->get(), array('edit' => 0, 'delete' => 1));
    }

    public function testGetAccessPartial()
    {
        $this->assertEqual($this->acl->get('edit'), 0);
        $this->assertEqual($this->acl->get('delete'), 1);
    }

    public function testGetAccessPartialNotExists()
    {
        $this->assertEqual($this->acl->get('somenotexistparam'), 0);
    }

    public function testRegister()
    {
        $acl = new acl(new userStub(2));
        $acl->register($obj_id = 10, $class = 'news', $section = 'news');

        $this->assertEqual(1, $acl->get('delete'));
        $this->assertEqual(1, $acl->get('edit'));

        $acl2 = new acl(new userStub(3));
        $this->assertEqual(1, $acl2->get('delete'));
        $this->assertEqual(1, $acl2->get('edit'));
    }

    public function testExceptionOnNotUser()
    {
        $this->db->query("INSERT INTO `user_user` (`id`, `login`) VALUES (1, 'Guest')");
        try {
            $acl = new acl('news', 'news', 'foo');
            $this->fail('Не было брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->assertPattern('/\$user не является инстанцией/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testDeleteNoArg()
    {
        $this->acl->delete();
        $stmt = $this->db->query('SELECT COUNT(*) AS `cnt` FROM `sys_access` WHERE `class_section_action` IN (1, 2) AND `obj_id` = 1');
        $row = $stmt->fetch();
        $this->assertEqual($row['cnt'], 0);
    }

    public function testDeleteArg()
    {
        $acl = new acl(new userStub(2));
        $acl->delete(1);
        $stmt = $this->db->query('SELECT COUNT(*) AS `cnt` FROM `sys_access` WHERE `class_section_action` IN (1, 2) AND `obj_id` = 1');
        $row = $stmt->fetch();
        $this->assertEqual($row['cnt'], 0);
    }

    public function testSet()
    {
        $this->db->query('DELETE FROM `sys_access` WHERE `id` = 3');
        $this->db->query('UPDATE `sys_access` SET `allow` = 0 WHERE `id` = 1');

        $acl = new acl(new userStub(), 1, 'news', 'news');

        $this->assertEqual($acl->get('edit'), 0);
        $acl->set('edit', 1);
        $this->assertEqual($acl->get('edit'), 1);

        $this->assertEqual($acl->get('delete'), 1);
        $acl->set('delete', 0);
        $this->assertEqual($acl->get('delete'), 0);
    }

    public function testSetArray()
    {
        $this->db->query('DELETE FROM `sys_access` WHERE `id` = 3');
        $this->db->query('UPDATE `sys_access` SET `allow` = 0 WHERE `id` = 1');

        $acl = new acl(new userStub(), 1, 'news', 'news');

        $this->assertEqual($acl->get('edit'), 0);
        $this->assertEqual($acl->get('delete'), 1);

        $acl->set($access = array('edit' => 1, 'delete' => 0));

        $this->assertEqual($acl->get(), $access);
    }

    public function testSetInvalid()
    {
        try {
            $this->acl->set('foo', 1);
            $this->fail('Должно быть брошено исключение');
        } catch (mzzInvalidParameterException $e) {
            $this->assertPattern('/У выбранного объекта .*foo/', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testSetUnregistered()
    {
        try {
            $acl = new acl(new userStub(), 666, 'news', 'news');
            $acl->set('foo', 1);
            $this->fail('Должно быть брошено исключение');
        } catch (mzzRuntimeException $e) {
            $this->assertEqual('Выбранный объект не зарегистрирован в acl', $e->getMessage());
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }

    public function testGetUsersList()
    {
        $this->db->query("INSERT INTO `user_user` (`id`, `login`) VALUES (1, 'Guest')");
        $users = $this->acl->getUsersList();

        $this->assertEqual(sizeof($users), 1);
        $this->assertEqual($users[0]->getLogin(), 'Guest');
    }

    public function testGetGroupsList()
    {
        $this->db->query("INSERT INTO `user_group` (`id`, `name`) VALUES (1, 'somegroup')");
        $groups = $this->acl->getGroupsList();

        $this->assertEqual(sizeof($groups), 1);
        $this->assertEqual($groups[0]->getName(), 'somegroup');
    }

    public function testGetClass()
    {
        $this->assertEqual($this->acl->getClass(), 'news');
    }
}

?>