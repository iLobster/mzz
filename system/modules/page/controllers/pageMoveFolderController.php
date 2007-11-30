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
 * pageMoveFolderController: контроллер для метода moveFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2
 */

class pageMoveFolderController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $folder = $folderMapper->searchByPath($path);
        if (!$folder) {
            $controller = new messageController('каталог не найден');
            return $controller->run();
        }

        $folders = $folderMapper->getTreeExceptNode($folder);
        if (sizeof($folders) <= 1) {
            $controller = new messageController('Невозможно перемещать данный каталог');
            return $controller->run();
        }

        $validator = new formValidator();

        $validator->add('required', 'dest', 'Обязательное для заполнения поле');
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array('checkDestFolderExists', $folderMapper));
        $validator->add('callback', 'dest', 'В каталоге назначения уже есть каталог с таким именем', array('checkUniqueFolderName', $folderMapper, $folder));
        $validator->add('callback', 'dest', 'Нельзя перенести каталог во вложенные каталоги', array('checkDestFolderIsNotChildren', $folders));

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);
            $result = $folderMapper->move($folder, $destFolder);
            if ($result) {
                return jipTools::redirect();
            }
            $errors->set('dest', 'Невозможно осуществить требуемое перемещение');
        }

        $url = new url('pageActions');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getPath());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        return $this->smarty->fetch('page/moveFolder.tpl');
    }
}

function checkUniqueFolderName($id, $folderMapper, $folder)
{
    if ($folder->getTreeParent()->getId() == $id) {
        return true;
    }
    $destFolder = $folderMapper->searchById($id);
    $someFolder = $folderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
    return empty($someFolder);
}

function checkDestFolderExists($id, $folderMapper)
{
    $destFolder = $folderMapper->searchById($id);
    return !empty($destFolder);
}

function checkDestFolderIsNotChildren($id, $folders)
{
    return isset($folders[$id]);
}
?>