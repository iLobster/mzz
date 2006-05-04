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
 * userExitView: вид для метода exit модуля user
 *
 * @package user
 * @version 0.1
 */

class userExitView extends simpleView
{
    public function toString()
    {
        header('Location: ' . $this->DAO);
        exit;
    }
}

?>
