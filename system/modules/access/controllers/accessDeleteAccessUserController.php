<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/modules/access/controllers/accessDeleteUserDefaultController.php $
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: accessDeleteUserDefaultController.php 3071 2009-03-25 00:08:37Z zerkms $
 */

/**
 * accessDeleteAccessUserController
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

class accessDeleteAccessUserController extends simpleController
{
    protected function getView()
    {
        if ($user_id = $this->request->getInteger('user_id')) {
            $this->module_name = $this->request->getString('module_name');

            $adminMapper = $this->toolkit->getMapper('admin', 'admin');
            $info = $adminMapper->getInfo();
            $module = $info[$this->module_name];
            $obj_id = $module['obj_id'];
            $module['name'] = $this->module_name;

            $userMapper = $this->toolkit->getMapper('user', 'user');
            $user = $userMapper->searchByKey($user_id);

            $acl = new acl($user, $obj_id);
            $acl->deleteUser($user_id);

            foreach ($adminMapper->searchClassesByModuleId($module['id']) as $class) {
                $acl = new acl($user, 0, $class['name']);
                $acl->deleteDefault();
            }
        }

        return jipTools::closeWindow();
    }
}

?>