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
fileLoader::load('orm/plugins/tree_mpPlugin');

/**
 * pageFolderMapper: маппер
 *
 * @package modules
 * @subpackage page
 * @version 0.1.4
 */

class pageFolderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'pageFolder';
    protected $table = 'page_pageFolder';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk',
                'once',
            ),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
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

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_mpPlugin(array('path_name' => 'name')), 'tree');
        $this->plugins('acl_ext');
        $this->plugins('jip');
    }


    public function searchByParentId($id)
    {
        return $this->searchOneByField('parent', $id);
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function searchByPath($path)
    {
        return $this->plugin('tree')->searchByPath($path . '/');
    }

    /**
     * Метод поиска страницы в каталоге
     *
     * @param string $name
     * @return page|null
     */
    public function searchChild($name, $controller = null)
    {
        $toolkit = systemToolkit::getInstance();
        $pageMapper = $toolkit->getMapper('page', 'page');

        if (strpos($name, '/') === false) {
            $name = 'root/' . $name;
        }

        $folder = substr($name, 0, strrpos($name, '/'));
        $pagename = substr(strrchr($name, '/'), 1);

        $pageFolder = $this->searchByPath($folder);

        if (!$pageFolder) {
            return null;
        }

        if ($controller instanceof simpleController) {
            $controller->acceptLang($pageMapper);
        }

        $criteria = new criteria();
        $criteria->add('name', $pagename)->add('folder_id', $pageFolder->getId());
        $page = $pageMapper->searchOneByCriteria($criteria);
        return $page;
    }

    /**
     * Возвращает уникальный для ДО идентификатор исходя из аргументов запроса
     *
     * @return integer
     */
    public function convertArgsToObj($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = 'root';
        }

        $pageFolder = $this->searchByPath($args['name']);
        if ($pageFolder) {
            return $pageFolder;
        }

        throw new mzzDONotFoundException();
    }
}

?>