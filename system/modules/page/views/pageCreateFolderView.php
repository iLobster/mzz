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
 * pageCreateFolderView: вид для метода editFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageCreateFolderView extends simpleView
{
    private $form;

    public function __construct($pageFolder, $form)
    {
        $this->form = $form;
        parent::__construct($pageFolder);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());

        $this->response->setTitle('Страницы -> Создание папки');
        return $this->smarty->fetch('page/createFolder.tpl');
    }
}

?>