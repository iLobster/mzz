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
 * userGroupEditView: вид для метода groupEdit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userGroupEditView extends simpleView
{
    private $form;
    private $action;

    public function __construct($group, $form, $action)
    {
        $this->form = $form;
        $this->action = $action;
        parent::__construct($group);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('group', $this->DAO);
        $this->smarty->assign('action', $this->action);

        $title = $this->action == 'edit' ? 'Редактирование группы -> ' . $this->DAO->getName() : 'Создание группы';

        $this->response->setTitle('Пользователь -> ' . $title);
        return $this->smarty->fetch('user/groupEdit.tpl');
    }
}

?>