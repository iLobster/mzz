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
    protected $cacheable = array('searchByName', 'getFolders', 'getItems');

    /**
     * Постфикс имени таблицы
     *
     * @var string
     */
    protected $tablePostfix = '_folder';
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

        $this->tree = new dbTreeNS($init);
        //echo'<pre>';print_r($this); echo'</pre>';
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
            return $this->createNewsFolderFromRow($row);
        }
    }

    /**
     * Создает объект newsFolder из массива
     *
     * @param array $row
     * @return object
     */
    private function createNewsFolderFromRow($row)
    {
        $map = $this->getMap();
        $newsFolder = new newsFolder($this->this(), $map);
        $newsFolder->import($row);
        $newsFolder->count = $this->getCount();
        return $newsFolder;
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($id)
    {
        // выбирается только нижележащий уровень
        $rawFolders = $this->tree->getBranch($id, 1);
        //echo'<pre>';var_dump($id); echo'</pre>';
        foreach($rawFolders as $row) {
            $folders[] = $this->createNewsFolderFromRow($row);
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
        $news = new newsMapper($this->section());
        $result = $news->searchByFolder($id);
        
        //$this->count = $news->getCount();
        
        return array($result, $news->getCount());
    }

    /**
     * Magic method __sleep
     *
     * @return array
     */
    public function __sleep()
    {
        return array('name', 'section', 'tablePostfix', 'relationTable', 'cacheable', 'className', 'table', 'count');
    }

    /**
     * Magic method __wakeup
     *
     */
    public function __wakeup()
    {
    }

    /**
     * Возвращает ссылку на данный объект или на объект объект cache
     *
     * @return object
     */
    public function this()
    {
        return (!empty($this->cache)) ? $this->cache : $this;
    }
}

?>