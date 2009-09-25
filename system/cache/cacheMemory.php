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
 * cacheMemory: драйвер кэширования в память
 *
 * @package system
 * @subpackage cache
 * @version 0.0.1
 */

class cacheMemory extends cache
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

    public function set($key, $value, array $tags = array())
    {
        $data = $this->setTags($value, $tags);

        return $this->data->set($key, $data);
    }

    public function get($key)
    {
        $data = $this->data->get($key);

        if (is_array($data) && isset($data['data'])) {
            $this->checkTags($data, $key);

            return $data['data'];
        }
    }

    public function delete($key)
    {
        if ($this->data->has($key)) {
            return $this->data->delete($key);
        }

        return false;
    }

    public function flush($params = array())
    {
        $this->data = new arrayDataspace();
        return true;
    }
}

?>