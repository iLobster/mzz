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
 * page404View: отображение ошибки 404
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class page404View extends simpleView
{

    public function toString()
    {
        $this->response->setTitle('Ошибка. Запрашиваемая страница не найдена.');
        return $this->smarty->fetch('page.notfound.tpl');
    }
}

?>