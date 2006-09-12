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
 * newsFolderMapper: маппер для папок новостей
 *
 * @package news
 * @version 0.2
 */

fileLoader::load('db/dbTreeNS');
fileLoader::load('news/newsFolder');

class newsFolderMapper extends simpleMapper
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
    protected $className = 'newsFolder';

    /**
     * Массив кешируемых методов
     *
     * @var array
     */
    // protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    /**
     * Постфикс имени таблицы
     *
     * @var string
     */
    //protected $tablePostfix = '_folder';
    /**
     * Постфикс имени таблицы
     *
     * @var string
     */
    protected $relationPostfix = 'folder_tree';

    /**
     * Конструктор
     *
     * @param string $section секция
     */
    public function __construct($section)
    {
        parent::__construct($section);
        $init = array ('data' => array('table' => $this->table, 'id' =>'parent'),
        'tree' => array('table' => $this->relationTable , 'id' =>'id'));

        $this->tree = new dbTreeNS($init, 'name');
    }

    /**
     * Выполняет поиск объекта по имени
     *
     * @param string $name имя
     * @return object|null
     */
    public function searchByName($name)
    {
        if (empty($name)) {
            $name = 'root';
        }
        return $this->searchOneByField('name', $name);
    }

    /**
     * Создает объект newsFolder из массива
     *
     * @param array $row
     * @return object
     */
    protected function createItemFromRow($row, $newsFolder)
    {
        if (empty($newsFolder)) {
            $map = $this->getMap();
            $newsFolder = new newsFolder($this, $map);
        }
        $row = $this->fill($row);
        $newsFolder->import($row);
        return $newsFolder;
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        // выбирается только нижележащий уровень
        $rawFolders = $this->tree->getBranch($id, $level);
        foreach($rawFolders as $row) {
            $folders[] = $this->createItemFromRow($row);
        }

        return $folders;
    }

    /**
     * Выборка папки на основе пути
     *
     * @param string $path Путь
     * @param string $deep Глубина выборки
     * @return array with nodes
     */
    public function getFolderByPath($path)
    {
        return $this->searchOneByField('path', $path);
    }

    /**
     * Выборка ветки(нижележащих папок) на основе пути
     *
     * @param  string     $path          Путь
     * @param  string     $deep          Глубина выборки
     * @return array with nodes
     */
    public function getFoldersByPath($path, $deep = 1)
    {
        // выбирается только нижележащий уровень
        $rawFolders = $this->tree->getBranchByPath($path, $deep);
        foreach($rawFolders as $row) {
            $folders[] = $this->createItemFromRow($row);
        }

        return $folders;
    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems($id)
    {
        $newsMapper = new newsMapper($this->section());

        if (!empty($this->pager)) {
            $newsMapper->setPager($this->pager);
        }

        $result = $newsMapper->searchByFolder($id);

        return $result;
    }
    /*
    public function __sleep()
    {
    return array('name', 'section', 'tablePostfix', 'relationTable', 'cacheable', 'className', 'table', 'count', 'tree');
    }

    public function __wakeup()
    {
    }

    public function this()
    {
    return (!empty($this->cache)) ? $this->cache : $this;
    } */

    public function convertArgsToId($args)
    {
        $newsFolder = $this->getFolderByPath(implode('/', $args));
        return (int)$newsFolder->getObjId();
    }
}

?>