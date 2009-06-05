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
        $validator->add('required', 'dest', 'Обязательное для заполнения поле');
        $validator->add('in', 'dest', 'Каталог назначения не существует', $folders->keys());
        $validator->add('callback', 'dest', 'В каталоге назначения уже есть каталог с таким именем', array(array($this, 'checkUniqueFolderName'), $folderMapper, $folder));
        $validator->add('callback', 'dest', 'Нельзя перенести каталог во вложенные каталоги', array(array($this, 'checkDestFolderIsNotChildren'), $folders));

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);

            $folder->setTreeParent($destFolder);
            $folderMapper->save($folder);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getTreePath());


        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('folder', $folder);
        return $this->smarty->fetch('fileManager/moveFolder.tpl');
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