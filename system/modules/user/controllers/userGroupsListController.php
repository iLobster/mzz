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
 * userGroupsListController: контроллер для метода groupsList модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */

fileLoader::load('user/views/userGroupsListView');

class userGroupsListController extends simpleController
{
    public function getView()
    {
        $groupMapper = $this->toolkit->getMapper('user', 'group', $this->request->getSection());

        return new userGroupsListView($groupMapper);
    }
}

?>