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
 * commentsFolderPostView: вид для метода post модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */


class commentsFolderPostView extends simpleView
{
    private $action;

    public function __construct($form, $action = 'post')
    {
        $this->action = $action;
        parent::__construct($form);
    }

    public function toString()
    {
        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $this->DAO->accept($renderer);

        $this->smarty->assign('action', $this->action);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('comments/post.tpl');
    }
}

?>