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

fileLoader::load('catalogue');

/**
 * catalogueMapper: маппер
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMapper extends simpleCatalogueMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'catalogue';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'catalogue';

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