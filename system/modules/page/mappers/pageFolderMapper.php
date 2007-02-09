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
fileLoader::load('db/dbTreeNS');

/**
 * pageFolderMapper: ������
 *
 * @package modules
 * @subpackage page
 * @version 0.1.1
 */
class pageFolderMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'page';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'pageFolder';

    /**
     * �����������
     *
     * @param string $section ������
     */
    public function __construct($section)
    {
        parent::__construct($section);

        $init = array ('mapper' => $this, 'joinField' => 'parent', 'treeTable' => $section . '_' . $this->className . '_tree');
        $this->tree = new dbTreeNS($init, 'name');
    }

    /**
     * ���������� �������� ������, ������� ����������� ������������� ������
     *
     * @return object
     */
    public function create()
    {
        $map = $this->getMap();
        return new pageFolder($this, $map);
    }

    /**
     * ���������� children-�����
     *
     * @return array
     */
    public function getFolders($id, $level = 1)
    {
        return $this->tree->getBranchContainingNode($id, $level);
    }

    /**
     * ���������� �������, ����������� � ������ �����
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
     * ������� ����� �� ������ ����
     *
     * @param string $path ����
     * @param string $deep ������� �������
     * @return array with nodes
     */
    public function searchByPath($path)
    {
        return $this->searchOneByField('path', $path);
    }

    /**
     * �������� ��������
     *
     * @param  newsFolder     $folder          ����� ��� ����������
     * @param  newsFolder     $targetFolder    ����� ����������, � ������� ���������
     * @return newsFolder
     */
    public function createSubfolder(pageFolder $folder, pageFolder $targetFolder)
    {
        $idParent = $targetFolder->getParent();
        return $this->tree->insertNode($idParent, $folder);
    }

    /**
     * �������� ����� ������ � ��������� �� ������ id
     * �� delete ������ ��� delete ������������ � tree ��� �������� ������
     *
     * @param string $id ������������� <b>���� ������</b> (parent) ���������� ��������
     * @return void
     */
    public function remove($id)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $pageMapper = $toolkit->getMapper($this->name, 'page');
        //$pageFolderMapper = $toolkit->getMapper('page', 'pageFolder');

        // @toDo ��� �� �� ���
        $removedFolders = $this->tree->getBranch($id);
        if(count($removedFolders)) {
            foreach($removedFolders as $folder) {
                $pages = $folder->getItems();
                if(count($pages)) {
                    foreach($pages as $page) {
                        $pageMapper->delete($page->getId());
                    }
                }
            }
        }

        $this->tree->removeNode($id);
    }

    /**
     * ����� ������ ������� � ��������
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
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        if (!isset($args['name'])) {
            $args['name'] = 'root';
        }

        $pageFolder = $this->searchByPath($args['name']);
        return (int)$pageFolder->getObjId();
    }
}

?>