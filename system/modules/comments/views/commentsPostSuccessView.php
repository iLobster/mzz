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
 * commentsPostSuccessView: вид для успешного метода create модуля comments
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class commentsPostSuccessView extends simpleView
{
    public function toString()
    {
        $this->response->redirect($this->DAO);
    }
}

?>