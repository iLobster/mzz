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
 * adminAdminView: вид для метода admin модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */


class adminAdminView extends simpleView
{
    private $section;
    private $module;

    public function __construct($section, $module)
    {
        $this->section = $section;
        $this->module = $module;
        parent::__construct($section);
    }

    public function toString()
    {
        $this->smarty->assign('section_name', $this->section);
        $this->smarty->assign('module_name', $this->module);
        return $this->smarty->fetch('admin/admin.tpl');
    }
}

?>