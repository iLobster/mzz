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
 * userMemberOfSuccessView
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

class userMemberOfSuccessView extends simpleView
{
    public function toString()
    {
        return "<script type=\"text/javascript\">location.href = location.href;</script>";
    }
}

?>