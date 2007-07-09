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
        if (($user_id = $this->request->get('id', 'integer')) != null) {
            $class = $this->request->get('class_name', 'string');
            $section = $this->request->get('section_name', 'string');

            $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
            $user = $userMapper->searchById($user_id);

            $acl = new acl($user, 0, $class, $section);
            $acl->deleteDefault();
        }

        return jipTools::closeWindow();
    }
}

?>