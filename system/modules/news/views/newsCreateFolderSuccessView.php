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
 * newsCreateFolderSuccessView: вид для успешного метода createFolder модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsCreateFolderSuccessView extends simpleView
{
    public function toString()
    {
        $url = new url();
        $url->addParam($this->DAO->getPath());
        $url->setAction('list');
        return '<script>window.close();window.opener.location = "' . $url->get() . '";window.opener.focus();</script>';
    }

}

?>