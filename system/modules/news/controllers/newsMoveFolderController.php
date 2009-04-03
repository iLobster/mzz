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
 * newsMoveFolderController: контроллер для метода moveFolder модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.2
 */

class newsMoveFolderController extends simpleController
{
    protected function getView()
    {
        $folderMapper = $this->toolkit->getMapper('news', 'newsFolder');
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
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array(
            array(
                $this,
                'checkDestNewsFolderExists'),
            $folderMapper));
        $validator->add('callback', 'dest', 'В каталоге назначения уже есть каталог с таким именем', array(
            array(
                $this,
                'checkUniqueNewsFolderName'),
            $folderMapper,
            $folder));
        $validator->add('callback', 'dest', 'Нельзя перенести каталог во вложенные каталоги', array(
            array(
                $this,
                'checkDestNewsFolderIsNotChildren'),
            $folders));

        $errors = $validator->getErrors();

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchByKey($dest);
            $folder->setTreeParent($destFolder);
            $folderMapper->save($folder);
            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('moveFolder');
        $url->add('name', $folder->getPath());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
        }

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $errors);
        return $this->smarty->fetch('news/moveFolder.tpl');
    }

    public function checkUniqueNewsFolderName($id, $folderMapper, $folder)
    {
        if ($folder->getTreeParent()->getId() == $id) {
            return true;
        }
        $destFolder = $folderMapper->searchByKey($id);
        $someFolder = $folderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
        return empty($someFolder);
    }

    public function checkDestNewsFolderExists($id, $folderMapper)
    {
        return !is_null($folderMapper->searchByKey($id));
    }

    public function checkDestNewsFolderIsNotChildren($id, $folders)
    {
        return isset($folders[$id]);
    }
}

?>