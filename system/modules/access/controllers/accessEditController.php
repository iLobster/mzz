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
 * accessEditController: контроллер для метода edit модуля access
 *
 * @package modules
 * @subpackage access
 * @version 0.1
 */

fileLoader::load('access/views/accessEditView');
//fileLoader::load('access');

class accessEditController extends simpleController
{
    public function getView()
    {
        /*if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }*/
        $id = $this->request->get('id', 'integer', SC_PATH);

        $acl = new acl($this->toolkit->getUser(), $id);
        $users = $acl->getUsersList();
        $groups = $acl->getGroupsList();

        //$accessMapper = $this->toolkit->getMapper('access', 'access', '');
        //$acls = $accessMapper->searchByObjId($id);

        /*
        foreach ($acls as $val) {
            var_dump($val->getUser()->getLogin());
            var_dump($val->getGroup()->getName());
        }*/

        return new accessEditView($users, $groups, $id);
    }
}

?>