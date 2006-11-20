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
 * accessDeleteGroupController: контроллер для метода deleteGroup модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessDeleteGroupView');

class accessDeleteGroupController extends simpleController
{
    public function getView()
    {
        if (($obj_id = $this->request->get('id', 'integer', SC_PATH)) != null) {
            $group_id = $this->request->get('user_id', 'integer', SC_PATH);


            $acl = new acl($this->toolkit->getUser(), $obj_id);
            $acl->deleteGroup($group_id);
        }

        return new simpleJipRefreshView();
    }
}

?>