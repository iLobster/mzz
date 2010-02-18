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

fileLoader::load('page/models/pageFolder');
fileLoader::load('orm/plugins/tree_mpPlugin');
fileLoader::load('modules/jip/plugins/jipPlugin');

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
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_mpPlugin(array('path_name' => 'name')), 'tree');
        $this->plugins('jip');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByPath($path)
    {
        $this->appendRoot($path);
        return $this->plugin('tree')->searchByPath($path . '/');
    }

    private function appendRoot(&$path)
    {
        if (strpos($path, 'root') !== 0) {
            $path = 'root/' . $path;
        }
    }

    /**
     * Метод поиска страницы в каталоге
     *
     * @param string $name
     * @return page|null
     */
    public function searchChild($name, $pageMapper = null)
    {
        if ($pageMapper == null) {
            $toolkit = systemToolkit::getInstance();
            $pageMapper = $toolkit->getMapper('page', 'page');
        }

        if (strpos($name, '/') === false) {
            $name = 'root/' . $name;
        }

        $folder = substr($name, 0, strrpos($name, '/'));
        $pagename = substr(strrchr($name, '/'), 1);

        $pageFolder = $this->searchByPath($folder);

        if (!$pageFolder) {
            return null;
        }

        $page = $pageMapper->searchByNameInFolder($pagename, $pageFolder->getId());
        return $page;
    }
}

?>