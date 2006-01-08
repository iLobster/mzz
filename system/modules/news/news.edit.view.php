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
 * @package news
 * @version 0.1
 */

class newsEditView extends simpleView
{
    public function __construct($tableModule, $form, $params = array())
    {
        $this->form = $form;
        parent::__construct($tableModule, $params);
    }
    public function toString()
    {
        $data = $this->tableModule->getNews($this->params[0]);
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('news', $data);
        $this->smarty->assign('title', 'Новости -> Редактирование -> ' . $data->get('title'));
        return $this->smarty->fetch('news.edit.tpl');
    }

}

?>