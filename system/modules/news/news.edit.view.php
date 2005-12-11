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
    public function toString()
    {

        if($this->model->getParam(0) !==false && $this->model->getParam(1) == 'save') {
            $this->model->saveNews();
            header('Location: /news/' . $this->model->getParam(0) . '/view');
            exit;
        } else {
            $data = $this->model->getNews();
            $form = $this->model->getForm($data);
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('news', $data);
            $this->smarty->assign('title', 'Новости -> Редактирование -> ' . $data['title']);
            return $this->smarty->fetch('news.edit.tpl');
        }
    }

}

?>