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
 * newsEditSuccessView: ��� ��� ��������� ������ edit ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class userEditSuccessView extends simpleView
{
    public function toString()
    {
        return '<script>window.close();window.opener.location.reload();window.opener.focus();</script>';
    }
}

?>
