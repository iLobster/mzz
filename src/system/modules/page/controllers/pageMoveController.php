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
 * pageMoveController: контроллер для метода move модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.2.1
 */

class pageMoveController extends simpleController
{
    protected function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $name = $this->request->getString('name');
        $page = $pageFolderMapper->searchChild($name);
        $dest = $this->request->getInteger('dest', SC_POST);

        if (!$page) {
            return $this->forward404($pageMapper);
        }

        $folders = $pageFolderMapper->searchAll();

        if (sizeof($folders) <= 1) {
            $controller = new messageController($this->action, i18n::getMessage('error_no_folder_to_move', 'page'));
            return $controller->run();
        }

        $validator = new formValidator();
        $validator->rule('required', 'dest', i18n::getMessage('error_dest_required', 'page'));
        $validator->rule('callback', 'dest', i18n::getMessage('error_dest_not_exists', 'page'), array(array($this, 'checkDestPageFolderExists'), $pageFolderMapper));

        if ($validator->validate()) {
            $destFolder = $pageFolderMapper->searchByKey($dest);

            $page->setFolder($destFolder);
            $pageMapper->save($page);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->add('name', $page->getFolder()->getTreePath() . '/' . $page->getName());

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
        }

        $this->view->assign('form_action', $url->get());
        $this->view->assign('dests', $dests);
        $this->view->assign('validator', $validator);
        $this->view->assign('page', $page);
        return $this->render('page/move.tpl');
    }

    public function checkDestPageFolderExists($dest, $folderMapper)
    {
        $destFolder = $folderMapper->searchById($dest);
        return (bool)$destFolder;
    }
}

?>