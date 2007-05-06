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
 * pageMoveController: контроллер дл€ метода move модул€ page
 *
 * @package modules
 * @subpackage page
 * @version 0.2
 */

class pageMoveController extends simpleController
{
    public function getView()
    {
        // @todo ???
        if (($name = $this->request->get('name', 'string', SC_PATH)) == false) {
            if (($name = $this->request->get('id', 'string', SC_PATH)) == false) {
                $name = 'main';
            }
        }
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $pageMapper = $this->toolkit->getMapper('page', 'page');
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        if (!$page) {
            return $pageMapper->get404()->run();
        }

        $folders = $pageFolderMapper->searchAll();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'ќб€зательное дл€ заполнени€ поле');
        $validator->add('callback', 'dest', ' аталог назначени€ не существует', array('checkDestPageFolderExists'));
        if ($validator->validate()) {
            $destFolder = $pageFolderMapper->searchById($dest);

            if (!$destFolder) {
                return $pageFolderMapper->get404()->run();
            }

            $page->setFolder($destFolder);
            $pageMapper->save($page);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->addParam('name', $page->getFolder()->getPath() . '/' . $page->getName());

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
        }

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('page', $page);
        return $this->smarty->fetch('page/move.tpl');

    }
}

function checkDestPageFolderExists($dest)
{
    $folderMapper = systemToolkit::getInstance()->getMapper('page', 'pageFolder');
    $destFolder = $folderMapper->searchById($dest);
    return (bool)$destFolder;
}
?>