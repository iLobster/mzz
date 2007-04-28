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
    public function getView()
    {
        $path = $this->request->get('name', 'string', SC_PATH);
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
        $validator->add('callback', 'name', 'Идентификатор должен быть уникален в пределах каталога', array('checkFolderName', $targetFolder, $folderMapper));

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $exts = $this->request->get('exts', 'string', SC_POST);
            $filesize = $this->request->get('filesize', 'integer', SC_POST);

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
        $url->addParam('name', $targetFolder->getPath());

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('folder', $targetFolder);
        return $this->smarty->fetch('fileManager/editFolder.tpl');
    }
}


function checkFolderName($name, $folder, $mapper)
{
    if ($name == $folder->getName()) {
        return true;
    }

    $path = $folder->getPath();
    if (($slash = strpos($path, '/')) !== false) {
        $path = substr($path, 0, $slash);
    }
    return is_null($mapper->searchByPath($path . '/' . $name));
}
?>