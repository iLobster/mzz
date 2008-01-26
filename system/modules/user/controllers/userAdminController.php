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
 * userAdminController: контроллер для метода admin модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userAdminController extends simpleController
{
    protected function getView()
    {
        $userFolderMapper = $this->toolkit->getMapper('user', 'userFolder');
        $folder = $userFolderMapper->getFolder();
        $this->smarty->assign('folder', $folder);

        $params = $this->request->get('params', 'string');
        if (empty($params)) {
            $params = 'users';
        }

        if ($params == 'groups') {
            $groupMapper = $this->toolkit->getMapper('user', 'group');
            $this->setPager($groupMapper);

            $this->smarty->assign('groups', $groupMapper->searchAll());
            return $this->smarty->fetch('user/admin_groups.tpl');
        } else if ($params == 'users') {
            $userMapper = $this->toolkit->getMapper('user', 'user');
            $this->setPager($userMapper);

            $this->smarty->assign('users', $userMapper->searchAll());
            return $this->smarty->fetch('user/admin.tpl');
        }

        return $userFolderMapper->get404()->run();
    }
}

?>