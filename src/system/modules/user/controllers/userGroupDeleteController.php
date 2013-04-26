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
 * userGroupDeleteController: контроллер для метода groupDelete модуля user
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class userGroupDeleteController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $groupMapper = $this->toolkit->getMapper('user', 'group');
        $group = $groupMapper->searchByKey($id);

        if (!$group) {
            return $groupMapper->get404()->run();
        }

        // удаляем группу
        $groupMapper->delete($group);
        return jipTools::redirect();
    }
}

?>