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
 * accessEditGroupDefaultView: вид для метода editGroupDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditGroupDefaultView extends simpleView
{
    private $actions;
    private $group;
    private $groups;
    private $class;
    private $section;

    public function __construct($acl, $actions, $group, $groups, $class, $section)
    {
        $this->actions = $actions;
        $this->group = $group;
        $this->groups = $groups;
        $this->class = $class;
        $this->section = $section;
        parent::__construct($acl);
    }

    public function toString()
    {
        if ($this->group) {
            $this->smarty->assign('acl', $this->DAO->getForGroupDefault($this->group->getId(), true));
        }
        $this->smarty->assign('group', $this->group);
        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('actions', $this->actions);
        $this->smarty->assign('class', $this->class);
        $this->smarty->assign('section', $this->section);

        $title = $this->group ? $this->group->getName() : 'добавить группу';
        $this->response->setTitle('ACL -> объект ... -> права по умолчанию -> ' . $title);

        return $this->smarty->fetch('access/editGroupDefault.tpl');
    }
}

?>