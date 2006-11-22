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
 * pageEditModel: вид для метода edit модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditView extends simpleView
{
    public function __construct($page, $form)
    {
        $this->form = $form;
        parent::__construct($page);
    }
    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('page', $this->DAO);

        $this->response->setTitle('Страницы -> Редактирование -> ' . $this->DAO->getName());
        return $this->smarty->fetch('page/edit.tpl');
    }

}

?>
