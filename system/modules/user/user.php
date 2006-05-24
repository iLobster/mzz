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
 * user: user
 *
 * @package user
 * @version 0.1.3
 */

class user extends simple
{
    /**
     * Проверяет является ли пользователь авторизированным
     * Пользователь считается вторизированным, если у него
     * установлен id больше 1
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getId() > 1;
    }
}

?>