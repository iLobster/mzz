<?php
require_once systemConfig::$pathToSystem . '/cache/iCache.php';

class memcached implements iCache
{
    protected $memcache;
    protected $connected = false;

    public function __construct(Array $params)
    {
        $host = isset($params['host']) ? $params['host'] : 'localhost';
        $port = isset($params['port']) ? $params['port'] : 11211;
        $timeout = isset($params['timeout']) ? $params['timeout'] : 1;

        $this->memcache = new Memcache();
        try {
            $this->memcache->connect($host, $port, $timeout);
            $this->connected = true;
        } catch (Exception $e) {
            $this->connected = false;
        }
    }

    public function add($key, $value, $expire = null, $params = array())
    {
        if ($this->isConnected()) {
            $flag = isset($params['flag']) ? $params['flag'] : null;
            return $this->memcache->add($key, $value, $flag, $expire);
        }

        return false;
    }

    public function set($key, $value, $expire = null, $params = array())
    {
        if ($this->isConnected()) {
            $flag = isset($params['flag']) ? $params['flag'] : null;
            return $this->memcache->set($key, $value, $flag, $expire);
        }

        return false;
    }

    public function get($key)
    {
        if ($this->isConnected()) {
            return $this->memcache->get($key);
        }

        return false;
    }

    public function delete($key, $params = array())
    {
        if ($this->isConnected()) {
            $timeout = isset($params['timeout']) ? $params['timeout'] : null;
            return $this->memcache->delete($key, $timeout);
        }

        return false;
    }

    public function flush($params = array())
    {
        if ($this->isConnected()) {
            return $this->memcache->flush();
        }

        return false;
    }

    protected function isConnected()
    {
        return $this->connected;
    }
}
?>