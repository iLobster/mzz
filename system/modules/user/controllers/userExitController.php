<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * userExitController: контроллер для метода exit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userExitController extends simpleController
{
    public function getView()
    {
        $session = $this->toolkit->getSession();
        $session->destroy('user_id');

        $userAuthMapper = $this->toolkit->getMapper('user', 'userAuth', 'user');
        $userAuthMapper->clear();

        $this->response->redirect($this->request->get('url', 'string', SC_GET));
    }
}

?>