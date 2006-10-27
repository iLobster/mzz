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

fileLoader::load('access/views/accessDeleteGroupDefaultView');

class accessDeleteGroupDefaultController extends simpleController
{
    public function getView()
    {
        if (($group_id = $this->request->get('id', 'integer', SC_PATH)) != null) {
            $class = $this->request->get('class_name', 'string', SC_PATH);
            $section = $this->request->get('section_name', 'string', SC_PATH);

            $acl = new acl($this->toolkit->getUser(), 0, $class, $section);
            $acl->deleteGroupDefault($group_id);
        }

        return new accessDeleteGroupDefaultView();
    }
}

?>