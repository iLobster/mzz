<?php

fileLoader::load('ldap/ldapReader');
mock::generate('ldapProxy');

/*$host = "ldap://asu.knaapo.ru";
$ldaprdn = 'cn=AD-Reader,ou=WEB,ou=Служебные бюджеты,dc=asu,dc=knaapo,dc=ru';
$ldappass = '';
$srdn = 'ou=КнААПО,dc=asu,dc=knaapo,dc=ru';

$pr = new ldapProxy($host, $ldaprdn, $ldappass);
echo '<br><pre>'; var_dump($pr->getList('DC=asu,DC=knaapo,DC=ru', '(objectClass=*)')); echo '<br></pre>';*/

class ldapReaderTest extends UnitTestCase
{
    private $ldapProxy;

    public function setUp()
    {
        $this->ldapProxy = new mockldapProxy();

        systemConfig::$db['ldap']['driver'] = 'ldap';
        systemConfig::$db['ldap']['dsn'] = 'ldap://asu.knaapo.ru';
        systemConfig::$db['ldap']['user'] = 'cn=AD-Reader,ou=WEB,ou=Служебные бюджеты,dc=asu,dc=knaapo,dc=ru';
        systemConfig::$db['ldap']['password'] = '';
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
        $this->ldapProxy->expectOnce('getList', array($rdn = 'OU=КнААПО,DC=asu,DC=knaapo,DC=ru', '(OU=*)'));
        $this->ldapProxy->setReturnValue('getList', $data = array());

        $reader = new ldapReader($rdn, $this->ldapProxy);
        $this->assertEqual($reader->getChild(), $data);
    }
}

?>