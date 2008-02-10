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

/**
 * accessDeleteUserDefaultController: контроллер для метода deleteUserDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

class accessDeleteUserDefaultController extends simpleController
{
    protected function getView()
    {
        if (($user_id = $this->request->getInteger('id')) != null) {
            $class = $this->request->getString('class_name');
            $section = $this->request->getString('section_name');

            $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
            $user = $userMapper->searchById($user_id);

            $acl = new acl($user, 0, $class, $section);
            $acl->deleteDefault();
        }

        return jipTools::closeWindow();
    }
}

?>