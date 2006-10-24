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
    private $sended = false;

    public function __construct($news, $form)
    {
        $this->form = $form;
        $this->xml = isset($_REQUEST['xajax']);
        parent::__construct($news);
        $this->xajaxInit();
    }

    public function toString()
    {
        $result = null;

        if (!$this->sended) {
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $this->form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('news', $this->DAO);

            $this->response->setTitle('Новости -> Редактирование -> ' . $this->DAO->getTitle());
            $this->sended = true;
            $result = $this->smarty->fetch('news.edit.tpl');
        } 
        if ($this->xml) {
            $objResponse = new xajaxResponse;
            $objResponse->addAssign("jip","innerHTML", $result);
            $this->xml = false;
            return $objResponse;
        } else { 
            return $result;
        }
    }
}

?>
