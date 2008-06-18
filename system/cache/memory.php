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
 * memory: класс для работы с кэшем
 *
 * @package system
 * @subpackage cache
 * @version 0.3.1
 */

class memory implements iCache
{
    /**
     * Контейнер для данных
     *
     * @var arrayDataspace
     */
    private $data;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->flush();
    }

    public function add($key, $value, $expire = null, $params = array())
    {
        $this->set($key, $value);
    }

    public function set($key, $value, $expire = null, $params = array())
    {
        $this->data->set($key, $value);
    }

    public function get($key)
    {
        return $this->data->get($key);
    }

    public function delete($key, $params = array())
    {
        if ($this->data->has($key)) {
            $this->data->delete($key);
        }
    }

    public function flush($params = array())
    {
        $this->data = new arrayDataspace();
    }
}

?>