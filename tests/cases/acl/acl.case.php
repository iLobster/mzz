<?php

fileLoader::load('acl');

class userStub
{
    function getId()
    {
        return 1;
    }

    function getGroupsId()
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
        $this->db->query("INSERT INTO `sys_access` (`id`, `module_property`, `type`, `uid`, `gid`, `allow`, `deny`, `obj_id`) VALUES (1,1,'news',1,NULL,1,NULL,1), (2,2,'news',1,NULL,1,NULL,1), (3,1,'news',NULL,1,1,1,1)");
        $this->db->query("INSERT INTO `sys_access_modules` (`id`, `module_id`, `section`) VALUES (1,1,'news')");
        $this->db->query("INSERT INTO `sys_access_modules_list` (`id`, `name`) VALUES (1,'news')");
        $this->db->query("INSERT INTO `sys_access_modules_properties` (`id`, `module_id`, `property_id`) VALUES (1,1,1), (2,1,2)");
        $this->db->query("INSERT INTO `sys_access_properties` (`id`, `name`) VALUES (1,'edit'), (2,'delete')");

        $this->acl = new acl('news', 'news', 'news', new userStub(), 1);
    }

    public function tearDown()
    {
        $this->clearDb();
    }

    public function clearDb()
    {
        $this->db->query('TRUNCATE TABLE `sys_access`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules_list`');
        $this->db->query('TRUNCATE TABLE `sys_access_modules_properties`');
        $this->db->query('TRUNCATE TABLE `sys_access_properties`');
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
}

?>