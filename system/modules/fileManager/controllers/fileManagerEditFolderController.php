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

fileLoader::load('forms/validators/formValidator');

/**
 * fileManagerEditFolderController: контроллер для метода editFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */
class fileManagerEditFolderController extends simpleController
{
    protected function getView()
    {
        $path = $this->request->getString('name');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $targetFolder = $folderMapper->searchByPath($path);

        if (!$targetFolder) {
            return $folderMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо дать идентификатор папке');
        $validator->add('required', 'title', 'Необходимо назвать папку');
        $validator->add('numeric', 'filesize', 'Размер должен быть числовым');
        $validator->add('regex', 'exts', 'Недопустимые символы в расширении', '/^[a-zа-я0-9_;\-\.! ]+$/i');
        $validator->add('regex', 'name', 'Недопустимые символы в идентификаторе', '/^[a-zа-я0-9_\.\-! ]+$/i');
        $validator->add('callback', 'name', 'Идентификатор должен быть уникален в пределах каталога', array('checkFileFolderName', $path, $folderMapper, $isEdit));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', 'string', SC_POST);
            $exts = $this->request->getString('exts', SC_POST);
            $filesize = $this->request->getInteger('filesize', SC_POST);

            if ($isEdit) {
                $folder = $targetFolder;
                $targetFolder = null;
            } else {
                $folder = $folderMapper->create();
            }

            $folder->setName($name);
            $folder->setTitle($title);
            $folder->setExts($exts);
            $folder->setFilesize($filesize);

            $folderMapper->save($folder, $targetFolder);
            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction($action);
        $url->add('name', $targetFolder->getPath());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->smarty->assign('folder', $targetFolder);
        return $this->smarty->fetch('fileManager/editFolder.tpl');
    }
}


function checkFileFolderName($name, $path, $mapper, $isEdit)
{
    /* wtf?
    $path = $folder->getPath();
    if (($slash = strpos($path, '/')) !== false) {
        $path = substr($path, 0, $slash);
    }*/
    if ($isEdit) {
        $path = explode('/', $path);
        $current = array_pop($path);

        return $current == $name || is_null($mapper->searchByPath(implode('/', $path) . '/' . $name));
    } else {
        return is_null($mapper->searchByPath($path . '/' . $name));
    }
}
?>