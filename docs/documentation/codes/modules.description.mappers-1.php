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
 * @package modules
 * @subpackage news
 * @version 0.2.1
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
     * Выполняет поиск объекта по идентификатору
     *
     * @param integer $id идентификатор
     * @return object|null
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * Выполняет поиск объектов по идентификатору папки
     *
     * @param integer $id идентификатор папки
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', $folder_id);
    }

    /**
     * Выполнение операций с массивом $fields перед обновлением в БД
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        $fields['updated'] = new sqlFunction('UNIX_TIMESTAMP');
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