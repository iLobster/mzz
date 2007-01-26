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
 * adminAddClassToSectionController: контроллер для метода addClassToSection модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */
class adminAddClassToSectionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $db = DB::factory();

        $data = $db->getRow('SELECT * FROM `sys_sections` WHERE `id` = ' . $id);

        if ($data === false) {
            // @todo изменить
            return 'раздела не существует';
        }

        $stmt = $db->query('SELECT `c`.`id` AS `c_id`, `c`.`name` AS `c_name`, `m`.`name` AS `m_name`, `cs`.`section_id` IS NOT NULL AS `checked`, (COUNT(`r`.`class_section_id`) > 0) AS `disabled` FROM `sys_classes` `c`
                             INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id`
                              LEFT JOIN `sys_classes_sections` `cs` ON `cs`.`class_id` = `c`.`id` AND `cs`.`section_id` = ' . $data['id'] . '
                               LEFT JOIN `sys_access_registry` `r` ON `r`.`class_section_id` = `cs`.`id`
                                GROUP BY `c`.`id`, `cs`.`id`
                                 ORDER BY `c`.`name`');

        $result = array();
        while ($tmp = $stmt->fetch()) {
            $result[$tmp['c_id']] = $tmp;
        }

        if ($this->request->getMethod() == 'POST') {
            $checkboxes = $this->request->get('class', 'array', SC_POST);

            $insert = ''; $delete = array();
            foreach ($result as $key => $val) {
                if (!$val['disabled']) {
                    if ($val['checked'] && !isset($checkboxes[$key])) {
                        $delete[] = $key;
                    } elseif(!$val['checked'] && isset($checkboxes[$key])) {
                        $insert .= '(' . $key . ', ' . $data['id'] . '), ';
                    }
                }
            }

            if ($insert) {
                $insert = substr($insert, 0, -2);
                $db->query('INSERT INTO `sys_classes_sections` (`class_id`, `section_id`) VALUES ' . $insert);
            }

            if ($delete) {
                $db->query('DELETE FROM `sys_classes_sections` WHERE `section_id` = ' . $data['id'] . ' AND `class_id` IN (' . implode(', ', $delete) . ')');
            }

            return new simpleJipRefreshView();
        }

        $this->smarty->assign('list', $result);
        $this->smarty->assign('data', $data);
        return $this->smarty->fetch('admin/addClassToSection.tpl');
    }
}

?>