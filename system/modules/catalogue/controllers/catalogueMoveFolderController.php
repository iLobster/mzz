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
 * catalogueMoveFolderController: контроллер дл€ метода moveFolder модул€ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMoveFolderController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $folder = $folderMapper->searchByPath($path);
        if (!$folder) {
            $controller = new messageController(' аталог не найден');
            return $controller->run();
        }

        $folders = $folderMapper->getTreeExceptNode($folder);
        if (sizeof($folders) <= 1) {
            $controller = new messageController('Ќевозможно перемещать данный каталог');
            return $controller->run();
        }

        $validator = new formValidator();

        $validator->add('required', 'dest', 'ќб€зательное дл€ заполнени€ поле');
        $validator->add('callback', 'dest', ' аталог назначени€ не существует', array('checkDestCatalogueFolderExists', $folderMapper));
        $validator->add('callback', 'dest', '¬ каталоге назначени€ уже есть каталог с таким именем', array('checkUniqueCatalogueFolderName', $folderMapper, $folder));
        $validator->add('callback', 'dest', 'Ќельз€ перенести каталог во вложенные каталоги', array('checkDestCatalogueFolderIsNotChildren', $folders));

        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);
            $result = $folderMapper->move($folder, $destFolder);
            if ($result) {
                return jipTools::redirect();
            }
            $errors->set('dest', 'Ќевозможно осуществить требуемое перемещение');
        }

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getPath());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $errors);
        return $this->smarty->fetch('catalogue/moveFolder.tpl');
    }
}

function checkUniqueCatalogueFolderName($id, $folderMapper, $folder)
{
    if ($folder->getTreeParent()->getId() == $id) {
        return true;
    }
    $destFolder = $folderMapper->searchById($id);
    $someFolder = $folderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
    return empty($someFolder);
}

function checkDestCatalogueFolderExists($id, $folderMapper)
{
    $destFolder = $folderMapper->searchById($id);
    return !empty($destFolder);
}

function checkDestCatalogueFolderIsNotChildren($id, $folders)
{
    return isset($folders[$id]);
}

?>