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
 * newsEditSuccessView: вид для успешного метода edit модуля news
 *
 * @package news
 * @version 0.1
 */

class newsEditSuccessView extends simpleView
{
    protected $form;

    public function __construct($news, $form, $params = array())
    {
        $this->form = $form;
        parent::__construct($news, $params);
    }

    public function toString()
    {

        $values = $this->form->exportValues();
        $this->tableModule->update($values);
        header('Location: /news/' . $values['id'] . '/view');
        exit;

    }

}
?>