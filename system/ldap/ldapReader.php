<?php

fileLoader::load('ldap/ldapProxy');

class ldapReader
{
    private $ldapProxy;
    private $rdn;
    private $data = array();

    public function __construct($rdn, $alias = 'ldap')
    {
        $this->rdn = $rdn;

        if ($alias instanceof ldapProxy) {
            $this->ldapProxy = $alias;
        } else {
            $this->ldapProxy = new ldapProxy(systemConfig::$db[$alias]['dsn'], systemConfig::$db[$alias]['user'], systemConfig::$db[$alias]['password'], systemConfig::$db[$alias]['charset'], systemConfig::$db[$alias]['port']);
        }
    }

    static public function search($srdn, $filter, $alias = 'ldap')
    {
        $ldapProxy = new ldapProxy(systemConfig::$db[$alias]['dsn'], systemConfig::$db[$alias]['user'], systemConfig::$db[$alias]['password'], systemConfig::$db[$alias]['charset'], systemConfig::$db[$alias]['port']);
        return $ldapProxy->search($srdn, $filter);
    }

    public function getData()
    {
        if (empty($this->data)) {
            $this->data = reset($this->ldapProxy->read($this->rdn, '(objectclass=*)'));
        }

        return $this->data;
    }

    public function getRdn()
    {
        return $this->rdn;
    }

    private function setData($data)
    {
        $this->data = $data;
    }

    public function getChild()
    {
        $child = $this->ldapProxy->getList($this->rdn, '(|(objectclass=organizationalUnit)(objectclass=domain))');

        $result = array();

        foreach ($child as $item) {
            $object = new ldapReader($item['dn'], $this->ldapProxy);
            $object->setData($item);

            $result[] = $object;
        }

        return $result;
    }

    public function getParent()
    {
        $parent_rdn = substr(strstr($this->rdn, ','), 1);

        return new ldapReader($parent_rdn, $this->ldapProxy);
    }
}

?>