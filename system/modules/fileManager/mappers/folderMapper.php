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
fileLoader::load('simple/simpleMapperForTree');

/**
 * folderMapper: ������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.4
 */

class folderMapper extends simpleMapperForTree
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

    protected $itemName = 'file';

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
        $folder = new folder($this, $this->getMap());
        $folder->section($this->section);
        return $folder;
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    /**
     * ���������� ���������� ��� �� ������������� ������ �� ���������� �������
     *
     * @return integer
     */
    public function convertArgsToId($args)
    {
        $folder = $this->searchByPath($args['name']);
        if ($folder) {
            return (int)$folder->getObjId();
        }

        throw new mzzDONotFoundException();
    }

    public function get404()
    {
        fileLoader::load('fileManager/controllers/fileManager404Controller');
        return new fileManager404Controller('folder');
    }
}

?>