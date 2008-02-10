<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * userExitController: контроллер для метода exit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.2
 */
class userExitController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        $user->setLastLogin(new sqlFunction('unix_timestamp'));

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $userMapper->logout();

        $userMapper->save($user);

        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth', 'user');
        $userAuthMapper->clear();
        $userAuthMapper->clearExpired(strtotime('-1 month'));

        $this->response->redirect($this->request->getString('url', SC_GET));
    }
}

?>