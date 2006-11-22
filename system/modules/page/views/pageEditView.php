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
 * pageEditModel: ��� ��� ������ edit ������ page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditView extends simpleView
{
    private $form;
    private $action;

    public function __construct($page, $form, $action)
    {
        $this->form = $form;
        $this->action = $action;
        parent::__construct($page);
    }
    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('page', $this->DAO);
        $this->smarty->assign('action', $this->action);

        $title = $this->action == 'edit' ? '�������������� -> ' . $this->DAO->getName() : '��������';
        $this->response->setTitle('�������� -> ' . $title);
        return $this->smarty->fetch('page/edit.tpl');
    }

}

?>
