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
 * cacheApc: драйвер кэширования APC
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1asdas
 */
class cacheApc implements iCache
{
    public function add($key, $value, $expire = null, $params = array())
    {
        return apc_add($key, $value, $expire);
    }

    public function set($key, $value, $expire = null, $params = array())
    {
        return apc_store($key, $value, $expire);
    }

    public function get($key)
    {
        $value = apc_fetch($key, $success);
        return ($success) ? $value : null;
    }

    public function delete($key, $params = array())
    {
        return apc_delete($key);
    }

    public function flush($params = array())
    {
        $cache_type = (isset($params['cache_type'])) ? $cache_type : null;
        return apc_clear_cache($cache_type);
    }
}
?>