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
 * adminDeleteModuleController: контроллер для метода deleteModule модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDeleteModuleController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $modules = $adminMapper->getModulesList();

        foreach ($modules as $val) {
            if ($val['id'] == $id) {
                if (sizeof($val['classes'])) {
                    // @todo изменить
                    return 'нельзя удалить модуль';
                }
                break;
            }
        }

        $db = DB::factory();
        $db->query('DELETE FROM `sys_modules` WHERE `id` = ' .$id);

        $url = new url();
        $url->setAction('devToolbar');
        return new simpleJipRefreshView($url->get());
    }
}

?>