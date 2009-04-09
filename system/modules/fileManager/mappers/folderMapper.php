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
fileLoader::load('orm/plugins/tree_mpPlugin');

/**
 * folderMapper: маппер
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */

class folderMapper extends mapper
{
    /**
     * Имя класса DataObject
     *
     * @var string
     */
    protected $class = 'folder';
    protected $table = 'fileManager_folder';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk', 'once'),
        ),
        'name' => array(
            'accessor' => 'getName',
            'mutator' => 'setName',
            'orderBy' => 1
        ),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle'
        ),
        'parent' => array(
            'accessor' => 'getParent',
            'mutator' => 'setParent'
        ),
        'path' => array(
            'accessor' => 'getPath',
            'mutator' => 'setPath'
        ),
        'filesize' => array(
            'accessor' => 'getFilesize',
            'mutator' => 'setFilesize'
        ),
        'exts' => array(
            'accessor' => 'getExts',
            'mutator' => 'setExts'
        ),
        'storage_id' => array(
            'accessor' => 'getStorage',
            'mutator' => 'setStorage',
            'relation' => 'one',
            'foreign_key' => 'id',
            'mapper' => 'fileManager/storageMapper'
        ),
        'files' => array(
            'accessor' => 'getFiles',
            'mutator' => 'setFiles',
            'relation' => 'many',
            'mapper' => 'fileManager/fileMapper',
            'foreign_key' => 'folder_id',
            'local_key' => 'id'
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->attach(new tree_mpPlugin(array('path_name' => 'name')), 'tree');
        $this->plugins('acl_ext');
        $this->plugins('jip');
    }

    public function searchById($id)
    {
        return $this->searchByKey($id);
    }

    public function searchByPath($path)
    {
        return $this->plugin('tree')->searchByPath($path . '/');
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