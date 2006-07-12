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
    private $user;

    public function __construct()
    {
        $this->db = db::factory();
    }

    public function setUp()
    {
        $this->clearDb();
        $this->db->query("INSERT INTO `sys_access` (`id`, `module_section_property`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES (1,1,1,NULL,1,NULL,1), (2,2,1,NULL,1,NULL,1), (3,1,NULL,1,1,1,1)");
        $this->db->query("INSERT INTO `sys_access` (`id`, `module_section_property`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES (4,1,3,NULL,1,NULL,0), (5,2,3,NULL,1,NULL,0), (6,2,NULL,4,1,NULL,0)");
        $this->db->query("INSERT INTO `sys_access` (`id`, `module_section_property`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES (7,1,0,NULL,1,NULL,0), (8,2,0,NULL,1,NULL,0)");
        $this->db->query("INSERT INTO `sys_access_modules` (`id`, `name`) VALUES (1,'news')");
        $this->db->query("INSERT INTO `sys_access_sections` (`id`, `name`) VALUES (1,'news')");
        $this->db->query("INSERT INTO `sys_access_modules_sections` (`id`, `module_id`, `section_id`) VALUES (1,1,1)");
        $this->db->query("INSERT INTO `sys_access_modules_sections_properties` (`id`, `module_section_id`, `property_id`) VALUES (1,1,1), (2,1,2)");
        $this->db->query("INSERT INTO `sys_access_properties` (`id`, `name`) VALUES (1,'edit'), (2,'delete')");

        $this->acl = new acl('news', 'news', new userStub(), 1);
    }

    public function tearDown()
    {
        $this->clearDb();
    }

    public function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_access`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_sections`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules_sections_properties`');
        $this->db->query('TRUNCATE TABLE `sys_access_properties`');
        $this->db->query('TRUNCATE TABLE `user_user`');
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
        $acl = new acl('news', 'news', new userStub(2), $obj_id = 10);
        $acl->register($obj_id);

        $this->assertEqual(1, $acl->get('delete'));
        $this->assertEqual(1, $acl->get('edit'));

        $acl2 = new acl('news', 'news', new userStub(3), $obj_id = 10);
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
        $stmt = $this->db->query('SELECT COUNT(*) AS `cnt` FROM `sys_access` WHERE `module_section_property` IN (1, 2) AND `obj_id` = 1');
        $row = $stmt->fetch();
        $this->assertEqual($row['cnt'], 0);

    }
}

?>