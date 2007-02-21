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
 * adminDeleteSectionController: ���������� ��� ������ deleteSection ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminDeleteSectionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $sections = $adminMapper->getSectionsList();

        if (!isset($sections[$id])) {
            return '������ �� ������';
        }

        if (sizeof($sections[$id]['classes'])) {
            // @todo ��������
            return '������ ������� ������';
        }

        $db = DB::factory();
        $db->query('DELETE FROM `sys_sections` WHERE `id` = ' .$id);

        $url = new url();
        $url->setAction('devToolbar');
        return jipTools::redirect($url->get());
    }
}

?>