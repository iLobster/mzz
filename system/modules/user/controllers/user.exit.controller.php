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

class userExitController
{
    public function __construct()
    {
        fileLoader::load('user/views/user.exit.view');
        //fileLoader::load("user");
        //fileLoader::load("user/mappers/userMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $session = $toolkit->getSession();
        $session->destroy('user_id');

        return new userExitView($httprequest->get('url', SC_GET));
    }
}

?>
