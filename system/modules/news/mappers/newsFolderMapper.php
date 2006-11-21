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
 * @package modules
 * @subpackage news
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
     * Поиск newsFolder по id
     *
     * @param integer $id
     * @return newsFolder
     */
    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
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
     * Возвращает Доменный Объект, который обслуживает запрашиваемый маппер
     *
     * @return object
     */
    public function create()
    {
        $map = $this->getMap();
        return new newsFolder($this, $map);
    }

    /**
     * Возвращает children-папки
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        return $this->tree->getBranchContainingNode($id); //, $level);
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
     * Удаление папки вместе с содежимым на основе id
     * не delete потому что delete используется в tree для удаления записи
     *
     * @param string $id идентификатор <b>узла дерева</b> (parent) удаляемого элемента
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $newsMapper = $toolkit->getMapper('news', 'news', $request->getSection());
        $newsFolderMapper = $toolkit->getMapper('news', 'newsFolder', $request->getSection());

        // @toDo как то не так
        foreach($this->tree->getBranch($id) as $folder) {
            $folderNews = $folder->getItems();
            foreach($folderNews as $news) {
                $newsMapper->delete($news->getId());
            }
        }

        $this->tree->removeNode($id);
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
        return $this->tree->getBranchByPath($path, $deep);

    }

    /**
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems($id)
    {
        $news = new newsMapper($this->section());

        if (!empty($this->pager)) {
            $news->setPager($this->pager);
        }

        $result = $news->searchByFolder($id);

        return $result;
    }

    public function convertArgsToId($args)
    {
        $newsFolder = $this->searchByPath($args['name']);
        return (int)$newsFolder->getObjId();
    }

    // DEPRECATED пользоваться $tree->insertNode()

    /*    public function createSubfolder(newsFolder $folder, newsFolder $targetFolder)
    {
    $id = $targetFolder->getParent();
    $node = $this->tree->insertNode($id);
    $parent = $node['id'];
    $folder->setParent($parent);
    }*/
}

?>