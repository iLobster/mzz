<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
*/

/**
 * userEditView: ��� ��� ������ edit ������ user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userEditView extends simpleView
{
    private $form;
    private $action;

    public function __construct($user, $form, $action)
    {
        $this->form = $form;
        $this->action = $action;
        parent::__construct($user);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('user', $this->DAO);
        $this->smarty->assign('action', $this->action);

        $title = $this->action == 'edit' ? '�������������� -> ' . $this->DAO->getLogin() : '��������';

        $this->response->setTitle('������������ -> ' . $title);
        return $this->smarty->fetch('user/edit.tpl');
    }
}

?>