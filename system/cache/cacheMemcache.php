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

/**
 * cacheMemcache: драйвер кэширования memcache
 *
 * @package system
 * @subpackage cache
 * @version 0.0.4
 */
class cacheMemcache extends cacheBackend
{
    const DEFAULT_HOST = '127.0.0.1';
    const DEFAULT_PORT = 11211;
    const DEFAULT_PERSISTENT = false;
    const DEFAULT_WEIGHT = 1;
    const DEFAULT_TIMEOUT = 1;
    const DEFAULT_RETRYINTERVAL = 15;
    const DEFAULT_STATUS = true;

    const DEFAULT_COMPRESSTRESHOLD = 20000;
    const DEFAULT_MINSAVINGS = 0.2;

    protected $memcache;

    private $expire = 60;

    public function __construct(Array $params = array())
    {
        if (!class_exists('Memcache')) {
            throw new mzzRuntimeException('Memcache extension doesn\'t installed');
        }

        $this->memcache = new Memcache();

        if (!isset($params['servers']) || !is_array($params['servers'])) {
            $params['servers'] = array(
                self::DEFAULT_HOST => array());
        }

        $defaultsParams = array(
            'port' => self::DEFAULT_PORT,
            'persistent' => self::DEFAULT_PERSISTENT,
            'weight' => self::DEFAULT_WEIGHT,
            'timeout' => self::DEFAULT_TIMEOUT,
            'retry_interval' => self::DEFAULT_RETRYINTERVAL,
            'status' => self::DEFAULT_STATUS,
            'failure_callback' => array(
                $this,
                'failureCallback'));
        foreach ($params['servers'] as $host => $serverParams) {
            $serverParams = array_merge($defaultsParams, $serverParams);
            if (!empty($serverParams['failure_callback']) && !is_callable($serverParams['failure_callback'])) {
                throw new mzzCallbackException($serverParams['failure_callback']);
            }

            $this->memcache->addServer($host, $serverParams['port'], (bool)$serverParams['persistent'], (int)$serverParams['weight'], (int)$serverParams['timeout'], (int)$serverParams['retry_interval'], (bool)$serverParams['status'], $serverParams['failure_callback']);
        }

        if (isset($params['compress']) && $params['compress'] == true) {
            $threshold = isset($params['threshold']) ? $params['threshold'] : self::DEFAULT_COMPRESSTRESHOLD;
            $min_savings = isset($params['min_savings']) ? $params['min_savings'] : self::DEFAULT_MINSAVINGS;
            $this->memcache->setCompressThreshold($threshold, $min_savings);
        }

        if (isset($params['expire'])) {
            $this->expire = $params['expire'];
        }

        $this->expire += time();
    }

    public function getStatus($host, $port)
    {
        return $this->memcache->getServerStatus($host, $port);
    }

    public function set($key, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->expire;
        } else {
            $expire += time();
        }

        try {
            return $this->memcache->set($key, $value, null, $expire);
        } catch (mzzException $e) {
            return false;
        }
    }

    public function get($key)
    {
        try {
            return $this->memcache->get($key);
        } catch (mzzException $e) {
            return null;
        }
    }

    public function delete($key)
    {
        try {
            return $this->memcache->delete($key);
        } catch (mzzException $e) {
            return false;
        }
    }

    public function flush($params = array())
    {
        try {
            return $this->memcache->flush();
        } catch (mzzException $e) {
            return false;
        }
    }

    public function increment($key, $value = 1)
    {
        try {
            $result = $this->memcache->increment($key, $value);

            if ($result === false) {
                $this->memcache->set($key, $result = 1);
            }

            return $result;
        } catch (mzzException $e) {
            return false;
        }
    }

    public function decrement($key, $value = 1)
    {
        try {
            return $this->memcache->decrement($key, $value);
        } catch (mzzException $e) {
            return false;
        }
    }

    public function inc($key)
    {
        if (!$this->memcache->increment($key)) {
            $this->memcache->set($key, 1);

        }
    }

    protected function getTag($tag)
    {
        return (int)$this->memcache->get('tag_' . $tag);
    }

    public function getStats()
    {
        return $this->memcache->getExtendedStats();
    }

    public function failureCallback($host, $port)
    {
        throw new mzzException('Memcache server "' . $host . ':' . $port . '" error');
    }
}
?>