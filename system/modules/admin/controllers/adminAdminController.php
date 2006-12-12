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
 * adminAdminController: контроллер для метода admin модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

fileLoader::load('admin/views/adminAdminView');

class adminAdminController extends simpleController
{
    public function getView()
    {
        $section = $this->request->get('section_name', 'string', SC_PATH);
        $module = $this->request->get('module_name', 'string', SC_PATH);

        $user = $this->toolkit->getUser();
        $obj_id = $this->toolkit->getObjectId('access_' . $section . '_' . $module);

        $mapper = $this->toolkit->getMapper($module, $module, $section);

        $mapper->register($obj_id, 'sys', 'access');
        $acl = new acl($user, $obj_id);

        $access = $acl->get('admin');

        /**
         * @todo подумать над тем, что должно быть в случае 403 здесь
         */
        return $access ? new adminAdminView($section, $module) : 'нет доступа';
    }
}

?>