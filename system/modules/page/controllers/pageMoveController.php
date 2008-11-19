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
        if (is_null($name = $this->request->getString('name'))) {
            if (is_null($name = $this->request->getString('id'))) {
                $name = 'main';
            }
        }
        $dest = $this->request->getInteger('dest', SC_POST);

        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        if (!$page) {
            return $pageMapper->get404()->run();
        }

        $folders = $pageFolderMapper->searchAll();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Обязательное для заполнения поле');
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array(array($this, 'checkDestPageFolderExists'), $pageFolderMapper));
        if ($validator->validate()) {
            $destFolder = $pageFolderMapper->searchById($dest);

            $page->setFolder($destFolder);
            $pageMapper->save($page);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->add('name', $page->getFolder()->getPath() . '/' . $page->getName());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('page', $page);
        return $this->smarty->fetch('page/move.tpl');
    }

    public function checkDestPageFolderExists($dest, $folderMapper)
    {
        $destFolder = $folderMapper->searchById($dest);
        return (bool)$destFolder;
    }
}

?>