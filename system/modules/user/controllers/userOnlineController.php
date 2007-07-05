<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * userOnlineController: контроллер для метода online модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userOnlineController extends simpleController
{
    public function getView()
    {
        $userOnlineMapper = $this->toolkit->getMapper('user', 'userOnline');
        $criteria = new criteria();
        $criteria->setOrderByFieldAsc('user_id.login');
        $criteria->addGroupBy('user_id');
        $criteria->addSelectField('COUNT(*)', 'userOnline' . userOnlineMapper::TABLE_KEY_DELIMITER . 'cnt');
        $users = $userOnlineMapper->searchAll($criteria);

        $guests = 0;
        foreach ($users as $key => $user) {
            if ($user->getUser()->getId() == MZZ_USER_GUEST_ID) {
                $guests = $user->fakeField('cnt');
                unset($users[$key]);
                break;
            }
        }

        $this->smarty->assign('guests', $guests);
        $this->smarty->assign('users', $users);

        return $this->smarty->fetch('user/online.tpl');
    }
}

?>