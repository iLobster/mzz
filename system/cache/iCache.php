<?php
interface iCache
{
    public function add($key, $value, $expire = null, $params = array());
    public function set($key, $value, $expire = null, $params = array());
    public function get($key);
    public function delete($key, $params = array());
    public function flush($params = array());
}
?>