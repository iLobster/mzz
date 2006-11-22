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
 * accessEditOwnerView: вид для метода editOwner модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditOwnerView extends simpleView
{
    private $actions;
    private $class;
    private $section;

    public function __construct($acl, $actions, $class, $section)
    {
        $this->actions = $actions;
        $this->class = $class;
        $this->section = $section;
        parent::__construct($acl);
    }

    public function toString()
    {
        $this->smarty->assign('acl', $this->DAO->getForOwner(true));
        $this->smarty->assign('actions', $this->actions);
        $this->smarty->assign('class', $this->class);
        $this->smarty->assign('section', $this->section);

        $this->response->setTitle('ACL -> объект ... -> права для владельца объекта');

        return $this->smarty->fetch('access/editOwner.tpl');
    }
}

?>