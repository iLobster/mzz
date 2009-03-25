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
 * accessDeleteGroupDefaultController: контроллер для метода deleteGroupDefault модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

class accessDeleteGroupDefaultController extends simpleController
{
    protected function getView()
    {
        if (($group_id = $this->request->getInteger('id')) != null) {
            $class = $this->request->getString('class_name');

            $acl = new acl($this->toolkit->getUser(), 0, $class);
            $acl->deleteGroupDefault($group_id);
        }

        return jipTools::closeWindow();
    }
}

?>