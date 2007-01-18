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
 * adminCreateModuleView: вид для метода addModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminAddModuleView extends simpleView
{
    private $data;
    private $module;
    private $action;

    public function __construct($data, $form, $action)
    {
        $this->form = $form;
        $this->data = $data;
        $this->action = $action;
        parent::__construct();
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('data', $this->data);
        $this->smarty->assign('action', $this->action);
        $this->smarty->assign('form', $renderer->toArray());
        return $this->smarty->fetch('admin/addModule.tpl');
    }
}

?>