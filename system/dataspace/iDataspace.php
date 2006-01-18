<?php
interface iDataspace
{
    public function set($key, $value);
    public function get($key);
    public function delete($key);
    public function exists($key);
}
?>