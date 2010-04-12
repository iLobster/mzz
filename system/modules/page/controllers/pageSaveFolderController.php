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
 * pageSaveFolderController: контроллер для метода saveFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2
 */
class pageSaveFolderController extends simpleController
{
    protected function getView()
    {
        $path = $this->request->getString('name');
        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        $folderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $targetFolder = $folderMapper->searchByPath($path);

        if (empty($targetFolder)) {
            return $this->forward404($folderMapper);
        }

        $validator = new formValidator();
        $validator->rule('required', 'name', i18n::getMessage('error_name_required', 'page'));
        $validator->rule('required', 'title', i18n::getMessage('error_folder_title_required', 'page'));
        $validator->rule('regex', 'name', i18n::getMessage('error_name_invalid_name', 'page'), '/^[-_a-z0-9]+$/i');
        $validator->rule('callback', 'name', i18n::getMessage('error_name_unique', 'page'), array(array($this, 'checkUniqueFolderName'), $path, $isEdit));

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

        $url = new url('withAnyParam');
        $url->add('name', $path);
        $url->setAction($action);

        $this->view->assign('action', $url->get());
        $this->view->assign('validator', $validator);
        $this->view->assign('isEdit', $isEdit);

        $targetFolder = $isEdit ? $targetFolder : $folderMapper->create();
        $this->view->assign('folder', $targetFolder);
        return $this->render('page/saveFolder.tpl');
    }

    public function checkUniqueFolderName($name, $path, $isEdit)
    {
        $mapper = $this->toolkit->getMapper('page', 'pageFolder');
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