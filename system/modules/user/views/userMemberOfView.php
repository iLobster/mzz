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
 * userMemberOfView: вид для метода memberOf модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */


class userMemberOfView extends simpleView
{
    private $id;
    private $result;
    private $selected;
    private $user;

    public function __construct($mapper, $id, $result, $selected, $user)
    {
        parent::__construct($mapper);
        $this->id = $id;
        $this->result = $result;
        $this->selected = $selected;
        $this->user = $user;
    }

    public function toString()
    {
        $this->config = $this->toolkit->getConfig($this->httprequest->getSection(), 'user');

        fileLoader::load('pager');

        $this->smarty->assign('groups', $this->result);
        $this->smarty->assign('selected', $this->selected);
        $this->smarty->assign('user', $this->user);
        //var_dump($query->toString());

        //$pager = new pager($this->httprequest->getUrl(), $this->httprequest->get('page', 'integer', SC_GET), $this->config->get('items_per_page'));
        /*
        $this->DAO->setPager($pager);

        $this->smarty->assign('groups', $this->DAO->searchAll());
        $this->smarty->assign('pager', $pager);

        $this->response->setTitle('Пользователь -> Список');
        */

        $this->response->setTitle('Пользователь -> ' . $this->user->getLogin() . ' -> список групп');

        return $this->smarty->fetch('user.memberOf.tpl');
    }
}

?>