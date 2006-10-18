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
 * accessAddUserController: контроллер для метода addUser модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessAddUserView');

class accessAddUserController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');

        $criteria = new criteria();
        $criterion = new criterion('a.uid', 'user_user.id', criteria::EQUAL, true);
        $criterion->addAnd(new criterion('a.obj_id', $id));
        $criteria->addJoin('sys_access', $criterion, 'a')->add('a.id', null, criteria::IS_NULL);

        $users = $userMapper->searchAllByCriteria($criteria);

        return new accessAddUserView();
    }
}

?>