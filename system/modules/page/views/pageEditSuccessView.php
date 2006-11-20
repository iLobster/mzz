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
 * pageEditSuccessView: вид для успешного метода edit модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditSuccessView extends simpleView
{
    protected $form;

    public function __construct($page, $form, $params = array())
    {
        $this->form = $form;
        parent::__construct($page, $params);
    }

    public function toString()
    {
        $url = new url();
        $url->addParam($this->DAO->getName());
        $url->setAction('view');

        echo "<script>window.opener.location='" . $url->get() . "'; window.close();</script>";
    }

}
?>