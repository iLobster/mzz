<?php

abstract class cacheBackend
{
    abstract public function set($key, $value, $expire = 60);

    abstract public function get($key);

    abstract public function delete($key);

    public function increment($key)
    {
        $value = (int)$this->get($key) + 1;
        $this->set($key, $value);
        return $value;
    }
}

?>