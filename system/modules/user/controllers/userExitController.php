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

        $userMapper = $this->toolkit->getMapper('user', 'user');
        $userMapper->updateLastLoginTime($user);

        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth');
        $userAuthMapper->clear($this->request->getString('auth', SC_COOKIE));
        $userAuthMapper->clearExpired(strtotime('-1 month'));

        $this->response->setCookie(userAuthMapper::$auth_cookie_name, '', 0, '/');

        $this->toolkit->setUser($userMapper->getGuest());

        $backUrl = $this->request->getString('url', SC_GET);
        if (!$backUrl) {
            $url = new url('default');
            $backUrl = $url->get();
        }

        $this->redirect($backUrl);
    }
}

?>