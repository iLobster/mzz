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
 * catalogueMoveController: контроллер для метода move модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMoveController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $id = $this->request->getInteger('id');

        $item = $catalogueMapper->searchByKey($id);

        if (!$item) {
            return $catalogueMapper->get404()->run();
        }

        $folder = $item->getFolder();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Необходимо указать каталог назначения');
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array('checkDestCatalogueFolderExists', $catalogueFolderMapper));

        if ($validator->validate()) {
            $dest = $this->request->getInteger('dest', SC_POST);
            $destFolder = $catalogueFolderMapper->searchByKey($dest);

            $item->setFolder($destFolder);
            $catalogueMapper->save($item);

            return jipTools::redirect();
        }

        $folders = $catalogueFolderMapper->searchAll();
        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $url = new url('withId');
        $url->setAction($this->request->getAction());
        $url->add('id', $id);

        $this->smarty->assign('item', $item);
        $this->smarty->assign('isMass', false);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('folder', $folder);
        return $this->smarty->fetch('catalogue/move.tpl');
    }
}

function checkDestCatalogueFolderExists($dest, $folderMapper)
{
    $destFolder = $folderMapper->searchById($dest);
    return (bool)$destFolder;
}

?>