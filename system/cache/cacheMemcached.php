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

        $defaultsParams = array(
        'port' => self::DEFAULT_PORT,
        'persistent' => self::DEFAULT_PERSISTENT,
        'weight' => self::DEFAULT_WEIGHT,
        'timeout' => self::DEFAULT_TIMEOUT,
        'retry_interval' => self::DEFAULT_RETRYINTERVAL,
        'status' => self::DEFAULT_STATUS,
        'failure_callback' => null,
        );
        foreach ($params['servers'] as $host => $serverParams) {
            $serverParams = array_merge($defaultsParams, $serverParams);
            if (!empty($serverParams['failure_callback']) && !is_callable($serverParams['failure_callback'])) {
                throw new mzzCallbackException($serverParams['failure_callback']);
            }

            $this->memcache->addServer(
            $host,
            $serverParams['port'],
            (bool)$serverParams['persistent'],
            (int)$serverParams['weight'],
            (int)$serverParams['timeout'],
            (int)$serverParams['retry_interval'],
            (bool)$serverParams['status'],
            $serverParams['failure_callback']
            );
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