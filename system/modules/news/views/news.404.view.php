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
 * NewsListModel: вид для метода list модуля news
 *
 * @package news
 * @version 0.2
 */

class news404View extends simpleView
{

    public function toString()
    {
        $this->response->setTitle('Ошибка. Запрашиваемая новость или папка не найдена.');
        return $this->smarty->fetch('news.notfound.tpl');
    }

}

?>