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

/**
 * fileManagerEditFolderController: контроллер для метода editFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2.1
 */
class fileManagerSaveFolderController extends simpleController
{
    protected function getView()
    {
        $path = $this->request->getString('name');
        $action = $this->request->getAction();
        $isEdit = $action == 'editFolder';

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $targetFolder = $folderMapper->searchByPath($path);

        if (!$targetFolder) {
            return $this->forward404($folderMapper);
        }

        $storageMapper = $this->toolkit->getMapper('fileManager', 'storage');
        $storages = array();
        foreach ($storageMapper->searchAll() as $storage) {
            $storages[$storage->getId()] = $storage->getName();
        }

        $validator = new formValidator();
        $validator->rule('required', 'name', 'Необходимо дать идентификатор папке');
        $validator->rule('required', 'title', 'Необходимо назвать папку');
        $validator->rule('numeric', 'filesize', 'Размер должен быть числовым');
        $validator->rule('regex', 'exts', 'Недопустимые символы в расширении', '/^[a-z0-9_;\-\.!]+$/i');
        $validator->rule('regex', 'name', 'Недопустимые символы в идентификаторе', '/^[a-z0-9_\.\-!]+$/i');
        $validator->rule('callback', 'name', 'Идентификатор должен быть уникален в пределах каталога', array(array($this, 'checkFileFolderName'), $path, $folderMapper, $isEdit));
        $validator->rule('in', 'storage', 'Недопустимый сторадж', array_keys($storages));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', SC_POST);
            $exts = $this->request->getString('exts', SC_POST);
            $filesize = $this->request->getInteger('filesize', SC_POST);
            $storage_id = $this->request->getInteger('storage', SC_POST);

            if ($isEdit) {
                $folder = $targetFolder;
                $targetFolder = null;
            } else {
                $folder = $folderMapper->create();
                $folder->setTreeParent($targetFolder);
            }

            $folder->setName($name);
            $folder->setTitle($title);
            $folder->setExts($exts);
            $folder->setFilesize($filesize);
            $folder->setStorage($storage_id);

            $folderMapper->save($folder);
            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction($action);
        $url->add('name', $targetFolder->getTreePath());

        $this->view->assign('storages', $storages);
        $this->view->assign('action', $url->get());
        $this->view->assign('errors', $validator->getErrors());
        $this->view->assign('isEdit', $isEdit);
        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->view->assign('validator', $validator);
        $this->view->assign('folder', $targetFolder);
        return $this->render('fileManager/saveFolder.tpl');
    }


    public function checkFileFolderName($name, $path, $mapper, $isEdit)
    {
        if ($isEdit) {
            $path = explode('/', $path);
            $current = array_pop($path);

            return $current == $name || is_null($mapper->searchByPath(implode('/', $path) . '/' . $name));
        } else {
            return is_null($mapper->searchByPath($path . '/' . $name));
        }
    }
}

?>