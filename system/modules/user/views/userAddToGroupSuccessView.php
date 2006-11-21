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

class userAddToGroupSuccessView extends simpleView
{
    public function toString()
    {
        $url = new url();
        $url->addParam('id', $this->httprequest->get('id', 'integer', SC_PATH));
        $url->setAction('addToGroup');
        $url->setSection($this->httprequest->getSection());
       // return "<script type=\"text/javascript\">location.href = '" . $url->get() . "';</script>";
    }
}

?>