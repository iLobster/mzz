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
fileLoader::load('fileManager/file');
/**
 * fileMapper: маппер
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */
class fileMapper extends simpleMapper
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = 'fileManager';

    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $className = 'file';

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