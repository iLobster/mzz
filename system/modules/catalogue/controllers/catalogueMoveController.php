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
        $user = $this->toolkit->getUser();
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');

        $id = $this->request->get('id', 'integer', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $isMassAction = false;
        if ($id) {
            $items = array($id);
            $item = $catalogueMapper->searchById($id);
        } else {
            $isMassAction = true;
            $items = array_keys((array) $this->request->get('items', 'mixed', SC_POST));
        }

        if (empty($items)) {
            return jipTools::redirect();
        }

        $folder = $catalogueMapper->searchById(current($items))->getFolder();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Необходимо указать каталог назначения');
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array('checkDestCatalogueFolderExists', $catalogueFolderMapper));

        if ($validator->validate()) {
            $destFolder = $catalogueFolderMapper->searchById($dest);

            $nonAccessible = array();
            foreach ($items as $id) {
                $catalogue = $catalogueMapper->searchById($id);
                if ($catalogue) {
                    $acl = new acl($user, $catalogue->getObjId());
                    if ($acl->get($this->request->getAction())) {
                        $catalogue->setFolder($destFolder);
                        $catalogueMapper->save($catalogue);
                    } else {
                        $nonAccessible[] = $id;
                    }
                }
            }

            if (empty($nonAccessible)) {
                return jipTools::redirect();
            } else {
                $this->smarty->assign('nonAccess', $nonAccessible);
                return $this->smarty->fetch('catalogue/nonAccess.tpl');
            }
        }

        $folders = $catalogueFolderMapper->searchAll();
        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $url = new url('withAnyParam');
        $url->setAction($this->request->getAction());
        $url->add('name', $isMassAction ? '' : $id);

        if (!$isMassAction) {
            $this->smarty->assign('item', $item);
        }

        $this->smarty->assign('items', $items);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);
        $this->smarty->assign('isMass', $isMassAction);
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