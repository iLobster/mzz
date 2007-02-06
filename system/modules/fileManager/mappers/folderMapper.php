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

fileLoader::load('fileManager/folder');
fileLoader::load('db/dbTreeNS');

/**
 * folderMapper: маппер
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class folderMapper extends simpleMapper
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
    protected $className = 'folder';

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);

        $init = array ('mapper' => $this, 'joinField' => 'parent', 'treeTable' => $section . '_' . $this->className . '_tree');
        $this->tree = new dbTreeNS($init, 'name');
    }

    /**
     * Возвращает Доменный Объект, который обслуживает запрашиваемый маппер
     *
     * @return object
     */
    public function create()
    {
        return new folder($this, $this->getMap());
    }

    /**
     * Выборка папки на основе пути
     *
     * @param string $path Путь
     * @param string $deep Глубина выборки
     * @return array with nodes
     */
    public function searchByPath($path)
    {
        return $this->searchOneByField('path', $path);
    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems($id)
    {
        $fileMapper = systemToolkit::getInstance()->getMapper($this->name, 'file');

        return $fileMapper->searchByFolder($id);
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        return $this->tree->getBranchContainingNode($id, $level);
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        $folder = $this->searchByPath($args['name']);
        return (int)$folder->getObjId();
    }
}

?>