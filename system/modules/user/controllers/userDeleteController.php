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
 * userDeleteController: контроллер для метода delete модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userDeleteController extends simpleController
{
    protected function getView()
    {
        // удаляем пользователя
        $id = $this->request->getInteger('id');
        $userMapper = $this->toolkit->getMapper('user', 'user');

        $user = $userMapper->searchByKey($id);

        if (!$user) {
            return $userMapper->get404()->run();
        }

        $userMapper->delete($user);
        return jipTools::redirect();
    }
}

?>