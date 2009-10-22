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
            return $this->forward404($folderMapper);
        }

        $folders = $folderMapper->plugin('tree')->getTreeExceptNode($folder);
        if (sizeof($folders) <= 1) {
            $controller = new messageController(i18n::getMessage('error_no_folder_to_move', 'news'));
            return $controller->run();
        }

        $validator = new formValidator();

        $validator->rule('required', 'dest', i18n::getMessage('error_dest_required', 'news'));
        $validator->rule('callback', 'dest', i18n::getMessage('error_dest_not_exists', 'news'), array(
            array(
                $this,
                'checkDestNewsFolderExists'),
            $folderMapper));
        $validator->rule('callback', 'dest', i18n::getMessage('error_already_has_this_folder', 'news'), array(
            array(
                $this,
                'checkUniqueNewsFolderName'),
            $folderMapper,
            $folder));
        $validator->rule('callback', 'dest', i18n::getMessage('error_could_not_move_to_children', 'news'), array(
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
        $url->add('name', $folder->getTreePath());

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
        }

        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('dests', $dests);
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
        $someFolder = $folderMapper->searchByPath($destFolder->getTreePath() . '/' . $folder->getName());
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