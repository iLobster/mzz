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
 * userEditView: вид для метода edit модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userEditView extends simpleView
{
    private $form;

    public function __construct($user, $form)
    {
        $this->form = $form;
        parent::__construct($user);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('user', $this->DAO);

        $this->response->setTitle('Пользователь -> Редактирование -> ' . $this->DAO->getLogin());
        return $this->smarty->fetch('user.edit.tpl');
    }
}

?>