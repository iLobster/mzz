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
    protected $class = 'folder';
    protected $table = 'fileManager_folder';

    protected $classOfItem = 'file';

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
        $this->plugins('acl_simple');
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

    public function getItems(folder $folder)
    {
        $mapper = systemToolkit::getInstance()->getMapper('fileManager', $this->classOfItem);

        if ($this->plugin('pager')) {
            $mapper->attach(new pagerPlugin($this->plugin('pager')->getPager()));
            $this->detach('pager');
        }

        return $mapper->searchAllByField('folder_id', $folder->getId());
    }

    public function delete($object)
    {
        $mapper = systemToolkit::getInstance()->getMapper('fileManager', $this->classOfItem);
        foreach ($mapper->searchAllByField('folder_id', $object->getId()) as $file) {
            $mapper->delete($file);
        }

        parent::delete($object);
    }

    public function convertArgsToObj($args)
    {
        $folder = $this->searchByPath($args['name']);
        if ($folder) {
            return $folder;
        }

        throw new mzzDONotFoundException();
    }
}

?>