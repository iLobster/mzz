<?php

class ldapProxy
{
    private $ldap;
    private $encoding;

    public function __construct($host, $rdn, $pass, $encoding = 'utf-8', $port = 389)
    {
        $this->encoding = $encoding;
        $this->ldap = ldap_connect($host, $port);

        /*ldap_set_option($this->ldap,LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldap,LDAP_OPT_REFERRALS, 0);*/

        ldap_bind($this->ldap, $this->encode($rdn), $this->encode($pass));
    }

    public function getList($srdn, $filter)
    {
        $result = ldap_list($this->ldap, $this->encode($srdn), $this->encode($filter));
        $entries = $this->decode(ldap_get_entries($this->ldap, $result));
        unset($entries['count']);
        return $entries;
    }

    public function search($srdn, $filter)
    {
        $result = ldap_search($this->ldap, $this->encode($srdn), $this->encode($filter));
        $entries = $this->decode(ldap_get_entries($this->ldap, $result));
        unset($entries['count']);
        return $entries;
    }

    public function read($srdn, $filter)
    {
        $result = ldap_read($this->ldap, $this->encode($srdn), $this->encode($filter));
        $entries = $this->decode(ldap_get_entries($this->ldap, $result));
        unset($entries['count']);
        return $entries;
    }

    private function encode($str)
    {
        return iconv($this->encoding, 'cp1251', $str);
    }

    private function decode($str)
    {
        if (is_array($str)) {
            $new = array();
            foreach ($str as $key => $val) {
                $new[$this->decode($key)] = $this->decode($val);
            }
            return $new;
        }

        return @iconv('cp1251', $this->encoding, $str);
    }
}

?>