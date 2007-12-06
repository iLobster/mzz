<?php

class ldapProxy
{
    private $ldap;
    private $encoding;

    public function __construct($host, $rdn, $pass, $encoding = 'utf-8', $port = 389)
    {
        $this->encoding = $encoding;
        $this->ldap = ldap_connect($host, $port);

        ldap_set_option($this->ldap,LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldap,LDAP_OPT_REFERRALS, 0);

        ldap_bind($this->ldap, $rdn, $pass);
    }

    public function getList($srdn, $filter)
    {
        $result = ldap_list($this->ldap, $srdn, $filter);
        return $this->parseResults($result);
    }

    public function search($srdn, $filter)
    {
        $result = ldap_search($this->ldap, $srdn, $filter);
        return $this->parseResults($result);
    }

    public function read($srdn, $filter)
    {
        $result = ldap_read($this->ldap, $srdn, $filter);
        return $this->parseResults($result);
    }

    private function parseResults($result)
    {
        $entries = ldap_get_entries($this->ldap, $result);
        unset($entries['count']);
        return $entries;
    }
}

?>