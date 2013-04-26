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
            return $this->forward404($folderMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'name', i18n::getMessage('error_name_required', 'news'));
        $validator->rule('required', 'title', i18n::getMessage('error_folder_title_required', 'news'));
        $validator->rule('regex', 'name', i18n::getMessage('error_name_invalid_name', 'news'), '/^[-_a-z0-9]+$/i');
        $validator->rule('callback', 'name', i18n::getMessage('error_name_unique', 'news'), array(array($this, 'checkUniqueFolderName'), $path, $isEdit));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', SC_POST);

            if ($isEdit) {
                $folder = $targetFolder;
            } else {
                $folder = $folderMapper->create();
                $folder->setTreeParent($targetFolder);
            }

            $folder->setName($name);
            $folder->setTitle($title);
            $folderMapper->save($folder);

            return jipTools::redirect();
        }

        $url = new url('newsFolder');
        $url->add('name', $path);
        $url->setAction($action);

        $this->view->assign('form_action', $url->get());
        $this->view->assign('validator', $validator);
        $this->view->assign('isEdit', $isEdit);

        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->view->assign('folder', $targetFolder);
        return $this->render('news/saveFolder.tpl');
    }

    public function checkUniqueFolderName($name, $path, $isEdit)
    {
        $mapper = $this->toolkit->getMapper('news', 'newsFolder');
        $this->acceptLang($mapper);
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