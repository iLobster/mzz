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
 * user404View: отображение ошибки 404
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class user404View extends simpleView
{
    public function toString()
    {
        $this->response->setTitle('Ошибка. Запрашиваемый пользователь не найден.');
        return $this->smarty->fetch('user.notfound.tpl');
    }
}

?>