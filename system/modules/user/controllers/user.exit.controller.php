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
 * @package user
 * @version 0.1
 */

class userExitController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('user/views/user.exit.view');
        parent::__construct();
    }

    public function getView()
    {
        $session = $this->toolkit->getSession();
        $session->destroy('user_id');

        return new userExitView($this->request->get('url', SC_GET));
    }
}

?>
