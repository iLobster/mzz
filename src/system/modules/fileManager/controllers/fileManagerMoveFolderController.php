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
 * fileManagerMoveFolderController: контроллер для метода moveFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.2
 */
class fileManagerMoveFolderController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->getString('name');
        $dest = $this->request->getInteger('dest', SC_POST);

        $folder = $folderMapper->searchByPath($path);
        if (!$folder) {
            $controller = new messageController('каталог не найден');
            return $controller->run();
        }

        $folders = $folderMapper->plugin('tree')->getTreeExceptNode($folder);
        if (sizeof($folders) <= 1) {
            $controller = new messageController('Невозможно перемещать данный каталог');
            return $controller->run();
        }

        $validator = new formValidator();
        $validator->rule('required', 'dest', 'Обязательное для заполнения поле');
        $validator->rule('in', 'dest', 'Каталог назначения не существует', $folders->keys());
        $validator->rule('callback', 'dest', 'В каталоге назначения уже есть каталог с таким именем', array(array($this, 'checkUniqueFolderName'), $folderMapper, $folder));
        $validator->rule('callback', 'dest', 'Нельзя перенести каталог во вложенные каталоги', array(array($this, 'checkDestFolderIsNotChildren'), $folders));

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);

            $folder->setTreeParent($destFolder);
            $folderMapper->save($folder);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getTreePath());

        $this->view->assign('form_action', $url->get());
        $this->view->assign('validator', $validator);

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->view->assign('dests', $dests);
        $this->view->assign('styles', $styles);
        $this->view->assign('folder', $folder);
        return $this->render('fileManager/moveFolder.tpl');
    }

    public function checkUniqueFolderName($id, $folderMapper, $folder)
    {
        if ($folder->getTreeParent()->getId() == $id) {
            return true;
        }
        $destFolder = $folderMapper->searchById($id);
        $someFolder = $folderMapper->searchByPath($destFolder->getTreePath() . '/' . $folder->getName());
        return empty($someFolder);
    }

    public function checkDestFolderIsNotChildren($id, $folders)
    {
        return isset($folders[$id]);
    }
}

?>