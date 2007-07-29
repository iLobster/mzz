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

        $isMassAction = false;
        if ($id) {
            $items = array($id);
        } else {
            $isMassAction = true;
            $items = array_keys((array) $this->request->get('items', 'mixed', SC_POST));
        }

        if (empty($items)) {
            return jipTools::redirect();
        }

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Необходимо указать каталог назначени');

        if ($validator->validate()) {
            $dest = $this->request->get('dest', 'integer', SC_POST);
            $destFolder = $catalogueFolderMapper->searchById($dest);

            if (!$destFolder) {
                $controller = new messageController('Каталог назначения не найден', messageController::WARNING);
                return $controller->run();
            }

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
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
        }

        $url = new url('withAnyParam');
        $url->setAction($this->request->getAction());
        $url->add('name', $isMassAction ? '' : $id);

        $this->smarty->assign('items', $items);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('select', $dests);
        return $this->smarty->fetch('catalogue/move.tpl');
    }
}

?>