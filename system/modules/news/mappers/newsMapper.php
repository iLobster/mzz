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
 * newsMapper: маппер для новостей
 *
 * @package news
 * @version 0.2
 */

class newsMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'news';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'news';

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
   // protected $cacheable = array('searchById');

    /**
     * Создает пустой объект DO
     *
     * @return object
     */
    public function create()
    {
        return new news($this->getMap());
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
            return $this->createNewsFromRow($row);
        } else {
            return false;
        }
    }

    /**
     * Выполняет поиск объектов по идентификатору папки
     *
     * @param integer $id идентификатор папки
     * @return object|false
     */
    public function searchByFolder($folder_id)
    {
        $stmt = $this->searchByField('folder_id', $folder_id);
        $result = array();

        while ($row = $stmt->fetch()) {
            $result[] = $this->createNewsFromRow($row);
        }

        return $result;
    }

    /**
     * Создает объект news из массива
     *
     * @param array $row
     * @return object
     */
    protected function createNewsFromRow($row)
    {
        $map = $this->getMap();
        $news = new news($map);
        $news->import($row);
        return $news;
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');

        if ($fields['editor'] instanceof user) {
            $id = $fields['editor']->getId();
            unset($fields['editor']);
            $fields['editor'] = $id;
        }

        // может тут проверить "если строка - то поискать юзверя по логину и вернуть ид" ?
    }

    /**
     * Выполнение операций с массивом $fields перед вставкой в БД
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $fields['created'] = new sqlFunction('UNIX_TIMESTAMP');
        $fields['updated'] = $fields['created'];
        if ($fields['editor'] instanceof user) {
            $fields['editor'] = $fields['editor']->getId();
        }
    }
}

?>