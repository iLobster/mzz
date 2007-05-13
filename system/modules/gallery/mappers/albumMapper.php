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
 * @version $Id$
 */

fileLoader::load('gallery/album');

/**
 * albumMapper: маппер
 *
 * @package modules
 * @subpackage gallery
 * @version 0.1
 */

class albumMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'gallery';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'album';

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
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        return 1;
    }
}

?>