<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * pageMapper: маппер для страниц
 *
 * @package page
 * @version 0.2
 */

class pageMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'page';

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
    protected $cacheable = array('searchByName');

    /**
     * Создает пустой объект DO
     *
     * @return object
     */
    public function create()
    {
        return new page($this->getMap());
    }

    /**
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|false
     */
    public function searchById($id)
    {
        $stmt = $this->searchByField('id', $id);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|false
     */
    public function searchByName($name)
    {
        $stmt = $this->searchByField('name', $name);
        $row = $stmt->fetch();

        if ($row) {
            return $this->createPageFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * Создает объект page из массива
     *
     * @param array $row
     * @return object
     */
    protected function createPageFromRow($row)
    {
        $map = $this->getMap();
        $page = new page($map);
        $page->import($row);
        return $page;
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'cacheable', 'className', 'table');
    }

    /**
     * Magic method __wakeup
     *
     * @return array
     */
    public function __wakeup()
    {
    }
}

?>