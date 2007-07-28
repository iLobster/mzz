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
fileLoader::load('simple/new_simpleMapperForTree');

/**
 * folderMapper: ������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.4
 */

class folderMapper extends new_simpleMapperForTree
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

    public function convertArgsToObj($args)
    {
        $folder = $this->searchByPath($args['name']);
        if ($folder) {
            return $folder;
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