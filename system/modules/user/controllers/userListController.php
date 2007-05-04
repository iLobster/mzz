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
 * userListController: контроллер для метода list модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1.1
 */
class userListController extends simpleController
{
    public function getView()
    {
        $userMapper = $this->toolkit->getMapper('user', 'user');
        $config = $this->toolkit->getConfig('user', $this->request->getSection());

        $this->setPager($userMapper, $config->get('items_per_page'), true);

        $this->smarty->assign('users', $userMapper->searchAll());
        $this->smarty->assign('obj_id', $userMapper->convertArgsToId(null));

        $this->response->setTitle('Пользователь -> Список');

        return $this->smarty->fetch('user/list.tpl');
    }
}

?>