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
 * userAddToGroupView: вид для метода addToGroup модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userAddToGroupView extends simpleView
{
    private $filter;
    private $group;

    public function __construct($users, $group, $filter)
    {
        parent::__construct($users);
        $this->filter = $filter;
        $this->group = $group;
    }

    public function toString()
    {
        fileLoader::load("libs/xajax/xajax.inc");
        $xajax = new xajax('http://mzz-dev.ru/user/1/addToGroupList');
        $xajax->registerFunction(array("update", $this, 'updateUsers'), XAJAX_GET);
        $this->smarty->assign('xajax_js', $xajax->getJavascript('/templates/'));
        $this->smarty->assign('filter', $this->filter);
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('group', $this->group);

        $this->response->setTitle('Группа -> ' . $this->group->getName() . ' -> добавление пользователей');
        $xajax->processRequests();
        return $this->smarty->fetch('user.addToGroup.tpl');
    }
    
    public function updateUsers($value)
    {
        $objResponse = new xajaxResponse();
        $this->smarty->assign('filter', $this->filter);
        $this->smarty->assign('users', $this->DAO);
        $this->smarty->assign('group', $this->group);
        $objResponse->addAssign("users","innerHTML", $this->smarty->fetch('user.addToGroupList.tpl'));
        return $objResponse;
    }

}

?>