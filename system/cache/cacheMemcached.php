<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage cache
 * @version $Id$
*/

require_once systemConfig::$pathToSystem . '/cache/iCache.php';

/**
 * cacheMemcached: драйвер кэширования memcached
 *
 * @package system
 * @subpackage cache
 * @version 0.0.4
 */
class cacheMemcached implements iCache
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 11211;
    const DEFAULT_PERSISTENT = true;
    const DEFAULT_WEIGHT = 1;
    const DEFAULT_TIMEOUT = 1;
    const DEFAULT_RETRYINTERVAL = 15;
    const DEFAULT_STATUS = true;

    const DEFAULT_COMPRESSTRESHOLD = 20000;
    const DEFAULT_MINSAVINGS = 0.2;

    protected $memcache;

    public function __construct(Array $params = array())
    {
        $this->memcache = new Memcache();

        if (!isset($params['servers']) || !is_array($params['servers'])) {
            $params['servers'] = array(self::DEFAULT_HOST => array());
        }

        foreach ($params['servers'] as $host => $server) {
            $port = isset($server['port']) ? $server['port'] : self::DEFAULT_PORT;
            $isPersistent = isset($server['persistent']) ? (bool)$server['persistent'] : self::DEFAULT_PERSISTENT;

            $weight = isset($server['weight']) ? (bool)$server['weight'] : self::DEFAULT_WEIGHT;
            $timeout = isset($server['timeout']) ? $server['timeout'] : self::DEFAULT_TIMEOUT;
            $retry_interval = isset($server['retry_interval']) ? (bool)$server['retry_interval'] : self::DEFAULT_RETRYINTERVAL;
            $status = isset($server['status']) ? $server['status'] : self::DEFAULT_STATUS;
            $failure_callback = (isset($server['failure_callback']) && is_callable($server['failure_callback'])) ? $server['failure_callback'] : null;

            $this->memcache->addServer($host, $port, $isPersistent, $weight, $timeout, $retry_interval, $status, $failure_callback);
        }

        if (isset($params['compress']) && $params['compress'] == true) {
            $threshold = isset($params['threshold']) ? $params['threshold'] : self::DEFAULT_COMPRESSTRESHOLD;
            $min_savings = isset($params['min_savings']) ? $params['min_savings'] : self::DEFAULT_COMPRESSTRESHOLD;
            $this->memcache->setCompressThreshold($threshold, $min_savings);
        }
    }

    public function add($key, $value, $expire = null, $params = array())
    {
        try {
            $flag = isset($params['flag']) ? $params['flag'] : null;
            return $this->memcache->add($key, $value, $flag, $expire);
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function set($key, $value, $expire = null, $params = array())
    {
        try {
            $flag = isset($params['flag']) ? $params['flag'] : null;
            return $this->memcache->set($key, $value, $flag, $expire);
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function get($key)
    {
        try {
            $value = $this->memcache->get($key);
            return ($value === false) ? null : $value;
        } catch (phpErrorException $e) {
            return null;
        }
    }

    public function delete($key, $params = array())
    {
        try {
            $timeout = isset($params['timeout']) ? $params['timeout'] : null;
            return $this->memcache->delete($key, $timeout);
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function flush($params = array())
    {
        try {
            return $this->memcache->flush();
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function increment($key, $value = 1)
    {
        try {
            return $this->memcache->increment($key, $value);
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function decrement($key, $value = 1)
    {
        try {
            return $this->memcache->decrement($key, $value);
        } catch (phpErrorException $e) {
            return false;
        }
    }

    public function getStats()
    {
        return $this->memcache->getExtendedStats();
    }
}
?>