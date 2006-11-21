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
 * newsCreateSuccessView: вид для успешного метода create модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsCreateSuccessView extends simpleView
{
    protected $form;

    public function __construct($news, $form, $params = array())
    {
        $this->form = $form;
        parent::__construct($news, $params);
    }

    public function toString()
    {
        $url = new url();
        $url->addParam('id', $this->DAO->getId());
        $url->setAction('view');

        $this->response->redirect($url->get());
    }
}

?>