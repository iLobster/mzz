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
 * news404View: отображение ошибки 404
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class news404View extends simpleView
{
    public function toString()
    {
        $this->response->setTitle('Ошибка. Запрашиваемая новость или папка не найдена.');
        return $this->smarty->fetch('news/notfound.tpl');
    }
}

?>