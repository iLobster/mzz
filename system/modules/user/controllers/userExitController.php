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
 * userExitController: ���������� ��� ������ exit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */
class userExitController extends simpleController
{
    protected function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $userMapper->logout();

        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth', 'user');
        $userAuthMapper->clear();

        $this->response->redirect($this->request->get('url', 'string', SC_GET));
    }
}

?>