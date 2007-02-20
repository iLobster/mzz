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
 * folderMapper: ������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class folderMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'fileManager';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'folder';

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
        return new folder($this, $this->getMap());
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
        return $this->tree->getNodeByPath($path);
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ���������� �������, ����������� � ������ �����
     *
     * @return array
     */
    public function getItems($id)
    {
        $fileMapper = systemToolkit::getInstance()->getMapper($this->name, 'file');

        return $fileMapper->searchByFolder($id);
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

    public function getTreeExceptNode($folder)
    {
        $tree = $this->tree->getTree();

        $subfolders = $this->tree->getBranch($folder);

        foreach (array_keys($subfolders) as $val) {
            unset($tree[$val]);
        }

        return $tree;
    }

    /**
     * �������� ��������
     *
     * @param  folder     $folder          ����� ��� ����������
     * @param  folder     $targetFolder    ����� ����������, � ������� ���������
     * @return folder
     */
    public function createSubfolder(folder $folder, folder $targetFolder)
    {
        $idParent = $targetFolder->getParent();
        return $this->tree->insertNode($idParent, $folder);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        $folder = $this->searchByPath($args['name']);
        return (int)$folder->getObjId();
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

        $fileMapper = $toolkit->getMapper($this->name, 'file');
        $folderMapper = $toolkit->getMapper($this->name, 'folder');

        // @toDo ��� �� �� ���
        $removedFolders = $this->tree->getBranch($id);
        if (count($removedFolders)) {
            foreach ($removedFolders as $folder) {
                $folderFiles = $folder->getItems();
                if (count($folderFiles)) {
                    foreach ($folderFiles as $news) {
                        $fileMapper->delete($news->getId());
                    }
                }
            }
        }

        $this->tree->removeNode($id);
    }

    public function move($folder, $destFolder)
    {
        return $this->tree->moveNode($folder->getParent(), $destFolder->getParent());
    }

    public function getTreeParent($id)
    {
        return $this->tree->getParentNode($id);
    }
}

?>