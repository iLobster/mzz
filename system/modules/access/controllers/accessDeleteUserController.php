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
 * accessDeleteUserController: контроллер для метода deleteUser модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessDeleteUserView');

class accessDeleteUserController extends simpleController
{
    public function getView()
    {
        if (($obj_id = $this->request->get('id', 'integer', SC_PATH)) != null) {
            $user_id = $this->request->get('user_id', 'integer', SC_PATH);


            $acl = new acl($this->toolkit->getUser(), $obj_id);
            $acl->deleteUser($user_id);
        }

        return new simpleJipRefreshView();
    }
}

?>