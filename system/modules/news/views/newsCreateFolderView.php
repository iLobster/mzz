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
 * newsCreateView: вид для метода create модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsCreateFolderView extends simpleView
{
    private $form;

    public function __construct($newsFolder, $form)
    {
        $this->form = $form;
        parent::__construct($newsFolder);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());

        $this->response->setTitle('Новости -> Создание папки');
        return $this->smarty->fetch('news/createFolder.tpl');
    }

}

?>
