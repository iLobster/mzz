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
 * @version 0.1
 */

fileLoader::load('user/views/userListView');

class userListController extends simpleController
{
    public function getView()
    {
        $userMapper = clone $this->toolkit->getMapper('user', 'user', $this->request->getSection());

        return new userListView($userMapper);
    }
}

?>