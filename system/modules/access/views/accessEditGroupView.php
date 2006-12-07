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
 * accessEditGroupView: вид для метода editGroup модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */


class accessEditGroupView extends simpleView
{
    private $actions;
    private $group;
    private $groups;

    public function __construct($acl, $actions, $group, $groups = false)
    {
        $this->actions = $actions;
        $this->group = $group;
        $this->groups = $groups;
        parent::__construct($acl);
    }

    public function toString()
    {
        if ($this->group) {
            $this->smarty->assign('acl', $this->DAO->getForGroup($this->group->getId(), true));
        }
        //var_dump($this->actions);
        $this->smarty->assign('group', $this->group);
        $this->smarty->assign('groups', $this->groups);
        $this->smarty->assign('actions', $this->actions);

        $title = $this->group ? $this->group->getName() : 'добавить группу';
        $this->response->setTitle('ACL -> объект ... -> ' . $title);

        return $this->smarty->fetch('access/editGroup.tpl');
    }
}

?>