<?php

fileLoader::load('ldap/ldapReader');
mock::generate('ldapProxy');

class ldapReaderTest extends UnitTestCase
{
    private $ldapProxy;

    public function setUp()
    {
        $this->ldapProxy = new mockldapProxy();

        systemConfig::$db['ldap']['driver'] = 'ldap';
        systemConfig::$db['ldap']['dsn'] = 'ldap://asu.knaapo.ru';
        systemConfig::$db['ldap']['user'] = 'AD-Reader@asu.knaapo.ru';
        systemConfig::$db['ldap']['password'] = 'pqowieuryt';
        systemConfig::$db['ldap']['charset'] = 'utf-8';
    }

    public function tearDown()
    {
        unset(systemConfig::$db['ldap']);
    }

    public function testGetNode()
    {
        $this->ldapProxy->expectOnce('read', array($rdn = 'OU=КнААПО,DC=asu,DC=knaapo,DC=ru', '(objectclass=*)'));
        $this->ldapProxy->setReturnValue('read', $data = array());

        $reader = new ldapReader($rdn, $this->ldapProxy);

        $this->assertEqual($reader->getData(), $data);
    }

    public function testGetChild()
    {
        $this->ldapProxy->expectOnce('getList', array($rdn = 'OU=КнААПО,DC=asu,DC=knaapo,DC=ru', '(objectclass=organizationalUnit)'));
        $this->ldapProxy->setReturnValue('getList', $data = array());

        $reader = new ldapReader($rdn, $this->ldapProxy);
        $this->assertEqual($reader->getChild(), $data);
    }

    public function testGetParent()
    {
        $this->ldapProxy->expectOnce('getList', array('DC=asu,DC=knaapo,DC=ru', '(objectclass=organizationalUnit)'));
        $this->ldapProxy->setReturnValue('getList', $data = array());

        $reader = new ldapReader('OU=КнААПО,DC=asu,DC=knaapo,DC=ru', $this->ldapProxy);
        $parent = $reader->getParent();

        $this->assertEqual($parent->getChild(), $data);
    }
}

?>