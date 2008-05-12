<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * catalogueMassActionController: контроллер для метода massAction модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueMassActionController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getString('action', SC_GET);
        $name = $this->request->getString('name');

        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $catalogueFolder = $catalogueFolderMapper->searchByPath($name);

        if (!$catalogueFolder) {
            return $catalogueFolderMapper->get404()->run();
        }

        $items = array_keys((array)$this->request->getRaw('items', SC_POST));

        $validItems = array();
        $deniedItems = array();

        if (!empty($items) && in_array($action, array('delete', 'move'))) {
            $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
            $criteria = new criteria;
            $criteria->add('folder_id', $catalogueFolder->getId())->add('id', $items, criteria::IN);

            $items = $catalogueMapper->searchAllByCriteria($criteria);

            foreach ($items as $item) {
                if ($item->getAcl($action)) {
                    $validItems[] = $item;
                } else {
                    $deniedItems[] = $item;
                }
            }

            if ($action == 'delete') {
                foreach ($validItems as $item) {
                    $catalogueMapper->delete($item);
                }
            } elseif ($action == 'move') {
                fileLoader::load('forms/validators/formValidator');

                $validator = new formValidator();
                $validator->add('required', 'dest', 'Необходимо указать каталог назначения');
                $validator->add('callback', 'dest', 'Каталог назначения не существует', array('checkDestCatalogueFolderExists', $catalogueFolderMapper));


                if ($validator->validate()) {
                    $dest = $this->request->getInteger('dest', SC_POST);
                    $destFolder = $catalogueFolderMapper->searchByKey($dest);

                    foreach ($validItems as $item) {
                        $item->setFolder($destFolder);
                        $catalogueMapper->save($item);
                    }
                } else {
                    $folders = $catalogueFolderMapper->searchAll();
                    $dests = array();
                    $styles = array();
                    foreach ($folders as $val) {
                        $dests[$val->getId()] = str_repeat('&nbsp;', ($val->getTreeLevel() - 1) * 5) . $val->getTitle();
                        $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
                    }

                    $url = new url('withAnyParam');
                    $url->setAction('massAction');
                    $url->add('name', $catalogueFolder->getPath());
                    $url->add('action', $action, true);

                    $this->smarty->disableMain();

                    $this->smarty->assign('isMass', true);
                    $this->smarty->assign('items', $items);
                    $this->smarty->assign('folder', $catalogueFolder);
                    $this->smarty->assign('errors', $validator->getErrors());
                    $this->smarty->assign('dests', $dests);
                    $this->smarty->assign('styles', $styles);
                    $this->smarty->assign('form_action', $url->get());
                    $this->smarty->assign('action', $action);
                    return $this->smarty->fetch('catalogue/move.tpl');
                }
            }
        }

        if ($deniedItems) {
            $this->smarty->assign('items', $deniedItems);
            return $this->smarty->fetch('catalogue/nonAccess.tpl');
        }

        return jipTools::redirect();
    }
}

function checkDestCatalogueFolderExists($dest, $folderMapper)
{
    $destFolder = $folderMapper->searchById($dest);
    return (bool)$destFolder;
}

?>