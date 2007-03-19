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
 * cache: класс для работы с кэшем
 *
 * @package system
 * @subpackage cache
 * @version 0.3.1
 */

class cache
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
        $this->drop();
    }

    /**
     * Метод помещения данных в кэш
     *
     * @param string $identifier идентификатор кэша
     * @param mixed $value значение, помещаемое в кэш
     */
    public function save($identifier, $value)
    {
        $this->data->set($identifier, $value);
    }

    /**
     * Метод извлечения данных из кэша
     *
     * @param string $identifier идентификатор кэша
     * @return mixed
     */
    public function load($identifier)
    {
        return $this->data->get($identifier);
    }

    /**
     * Метод для удаления содержимого кэша
     *
     */
    public function drop()
    {
        $this->data = new arrayDataspace();
    }
}

?>