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
 * adminDevToolbarView: вид для метода devToolbar модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDevToolbarView extends simpleView
{
    private $modules;
    private $sections;

    public function __construct($modules, $sections)
    {
        $this->modules = $modules;
        $this->sections = $sections;
        parent::__construct();
    }

    public function toString()
    {
        $this->smarty->assign('modules', $this->modules);
        $this->smarty->assign('sections', $this->sections);
        return $this->smarty->fetch('admin/devToolbar.tpl');
    }
}

?>