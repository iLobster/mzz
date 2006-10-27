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
 * accessDeleteUserDefaultController: ���������� ��� ������ deleteUserDefault ������ access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessDeleteUserDefaultView');

class accessDeleteUserDefaultController extends simpleController
{
    public function getView()
    {
        if (($user_id = $this->request->get('id', 'integer', SC_PATH)) != null) {
            $class = $this->request->get('class_name', 'string', SC_PATH);
            $section = $this->request->get('section_name', 'string', SC_PATH);

            $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
            $user = $userMapper->searchById($user_id);

            $acl = new acl($user, 0, $class, $section);
            $acl->deleteDefault();
        }

        return new accessDeleteUserDefaultView();
    }
}

?>