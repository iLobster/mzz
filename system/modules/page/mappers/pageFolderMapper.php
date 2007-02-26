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

fileLoader::load('page/pageFolder');
fileLoader::load('simple/simpleMapperForTree');
fileLoader::load('db/dbTreeNS');

/**
 * pageFolderMapper: маппер
 *
 * @package modules
 * @subpackage page
 * @version 0.1.2
 */

class pageFolderMapper extends simpleMapperForTree
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
    protected $className = 'pageFolder';

    protected $itemName = 'page';

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
        $map = $this->getMap();
        return new pageFolder($this, $map);
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
     * Возвращает объекты, находящиеся в данной папке
     *
     * @return array
     */
    public function getItems($id)
    {
        $page = systemToolkit::getInstance()->getMapper('page', 'page', $this->section());

        if (!empty($this->pager)) {
            $news->setPager($this->pager);
        }

        $result = $page->searchByFolder($id);

        return $result;
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
        return $this->tree->getNodeByPath($path);
    }

    /**
     * Создание подпапки
     *
     * @param  newsFolder     $folder          Папка для добавления
     * @param  newsFolder     $targetFolder    Папка назначения, в которую добавлять
     * @return newsFolder
     */
    /*public function createSubfolder(pageFolder $folder, pageFolder $targetFolder)
    {
        $idParent = $targetFolder->getParent();
        return $this->tree->insertNode($idParent, $folder);
    }*/

    /**
     * Метод поиска новости в каталоге
     *
     * @param string $name
     * @return news|null
     */
    public function searchChild($name)
    {
        $toolkit = systemToolkit::getInstance();
        $pageMapper = $toolkit->getMapper('page', 'page');

        if (strpos($name, '/') !== false) {
            $folder = substr($name, 0, strrpos($name, '/'));
            $pagename = substr(strrchr($name, '/'), 1);

            $pageFolder = $this->searchByPath($folder);

            $criteria = new criteria();
            $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
            $page = $pageMapper->searchOneByCriteria($criteria);
        } else {
            $page = $pageMapper->searchByName($name);
        }

        return $page;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = 'root';
        }

        $pageFolder = $this->searchByPath($args['name']);
        if ($pageFolder) {
            return (int)$pageFolder->getObjId();
        }

        throw new mzzDONotFoundException();
    }
}

?>