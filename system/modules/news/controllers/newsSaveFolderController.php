<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
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
 * newsSaveController: контроллер для метода save модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.2.1
 */
class newsSaveFolderController extends simpleController
{
    protected function getView()
    {
        $path = $this->request->getString('name');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        $folderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $this->acceptLang($folderMapper);

        $targetFolder = $folderMapper->searchByPath($path);

        if (empty($targetFolder)) {
            return $folderMapper->get404()->run();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо дать идентификатор папке');
        $validator->add('required', 'title', 'Необходимо назвать папку');
        $validator->add('regex', 'name', 'Недопустимые символы в идентификаторе', '/^[a-zа-я0-9_\.\-! ]+$/i');
        $validator->add('callback', 'name', 'Идентификатор должен быть уникален в пределах каталога', array('checkNewsFolderName', $path, $folderMapper, $isEdit));


        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', SC_POST);

            if ($isEdit) {
                $folder = $targetFolder;
                $targetFolder = null;
            } else {
                $folder = $folderMapper->create();
            }

            $folder->setName($name);
            $folder->setTitle($title);

            $folderMapper->save($folder, $targetFolder);
            return jipTools::redirect();
        }

        $url = new url('newsFolder');
        $url->add('name', $path);
        $url->setAction($action);

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);

        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->smarty->assign('folder', $targetFolder);
        return $this->smarty->fetch('news/saveFolder.tpl');
    }
}

function checkNewsFolderName($name, $path, $mapper, $isEdit)
{
    if ($isEdit) {
        $path = explode('/', $path);
        $current = array_pop($path);

        return $current == $name || is_null($mapper->searchByPath(implode('/', $path) . '/' . $name));
    } else {
        return is_null($mapper->searchByPath($path . '/' . $name));
    }
}
?>