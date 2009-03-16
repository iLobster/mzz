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

//fileLoader::load('db/dbTreeNS');
fileLoader::load('news/newsFolder');
fileLoader::load('orm/plugins/tree_mpPlugin');
fileLoader::load('orm/plugins/acl_extPlugin');
fileLoader::load('orm/plugins/jipPlugin');
fileLoader::load('orm/plugins/i18nPlugin');

/**
 * newsFolderMapper: маппер для папок новостей
 *
 * @package modules
 * @subpackage news
 * @version 0.3
 */

class newsFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'newsFolder';
    protected $table = 'news_newsFolder';

    protected $itemName = 'news';

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_mpPlugin(array('path_name' => 'name')), 'tree');
        $this->attach(new acl_extPlugin(), 'acl');
        $this->attach(new jipPlugin(), 'jip');
        $this->attach(new i18nPlugin(), 'i18n');
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

    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
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

    public function searchByPath($path)
    {
        return $this->plugin('tree')->searchByPath($path . '/');
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['name']) && $newsFolder = $this->searchByPath($args['name'])) {
            return $newsFolder;
        }

        throw new mzzDONotFoundException();
    }

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk', 'once',
            ),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n'
            )
        ),
        'parent' => array(
            'accessor' => 'getParent',
            'mutator' => 'setParent',
        ),
        'path' => array(
            'accessor' => 'getPath',
            'mutator' => 'setPath',
        ),
    );
}

?>