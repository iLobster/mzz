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
 * pageCreateView: вид для метода create модуля page
 *
 * @package page
 * @version 0.1
 */

class pageCreateView extends simpleView
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

        $this->response->setTitle('Страницы -> Создание');
        return $this->smarty->fetch('page.create.tpl');
    }

}

?>
