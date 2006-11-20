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
 * userLoginSuccessView: вид для успешного логина модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userLoginSuccessView extends simpleView
{
    public function toString()
    {
        $this->response->redirect($this->DAO);
    }
}

?>