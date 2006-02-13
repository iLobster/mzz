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
 * newsDeleteView: вид для успешного метода create модуля news
 *
 * @package news
 * @version 0.1
 */

class newsDeleteView extends simpleView
{
    public function toString()
    {
        $url = new url();
        $url->setAction('list');
        header('Location: ' . $url->get());
        exit;
    }
}
?>