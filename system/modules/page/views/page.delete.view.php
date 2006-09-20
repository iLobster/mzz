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
 * pageDeleteView: вид для успешного метода create модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageDeleteView extends simpleView
{
    public function toString()
    {
        $url = new url();
        $url->setAction('list');
        echo "<script>window.opener.location.reload(); window.close();</script>";
        exit;
    }
}
?>