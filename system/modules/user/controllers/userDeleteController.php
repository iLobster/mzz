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
 * userDeleteController: контроллер для метода delete модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userDeleteView');

class userDeleteController extends simpleController
{
    public function getView()
    {
        // удаляем пользователя
        $id = $this->request->get('id', 'integer', SC_PATH);
        $userMapper = $this->toolkit->getMapper('user', 'user', $this->request->getSection());
        $userMapper->delete($id);

        // исключаем пользователя из групп, в которых он состоял
        $userGroupMapper = $this->toolkit->getMapper('user', 'userGroup', $this->request->getSection());
        $groups = $userGroupMapper->searchAllByField('user_id', $id);

        foreach ($groups as $val) {
        	$userGroupMapper->delete($val->getId());
        }

        return new simpleJipRefreshView();
    }
}

?>