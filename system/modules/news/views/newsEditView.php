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
 * NewsEditModel: вид для метода edit модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsEditView extends simpleView
{
    private $form;
    private $action;

    public function __construct($news, $form, $action)
    {
        $this->form = $form;
        $this->action = $action;
        parent::__construct($news);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('news', $this->DAO);
        $this->smarty->assign('action', $this->action);

        $title = $this->action == 'edit' ? 'Редактирование -> ' . $this->DAO->getTitle() : 'Создание';
        $this->response->setTitle('Новости -> ' . $title);

        return $this->smarty->fetch('news/edit.tpl');
    }

}

?>
