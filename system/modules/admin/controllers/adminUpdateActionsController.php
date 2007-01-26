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
 * adminUpdateActionsController: ���������� ��� ������ updateActions ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminUpdateActionsController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);

        $db = DB::factory();

        $data = $db->getRow('SELECT `c`.`name` AS `c_name`, `c`.`id` AS `c_id`, `m`.`name` AS `m_name`, `m`.`id` AS `m_id` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);
        if ($data === false) {
            // @todo ��������
            return '������ �� ����������';
        }

        // �������� ��� ����� ��� ������� �� �� ��
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_classes_actions` `ca`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = ' . $id;
        $stmt = $db->query($qry);

        $actions_db = array();
        while ($row = $stmt->fetch()) {
            $actions_db[] = $row['name'];
        }

        // �������� ��� ����� ��� ������� �� �� INI-�����
        $action = new action($data['m_name']);
        $tmp = $action->getActions(true);

        if (isset($tmp[$data['c_name']])) {
            $actions_ini = array_keys($tmp[$data['c_name']]);

            $to_delete = array_diff($actions_db, $actions_ini);
            $to_insert = array_diff($actions_ini, $actions_db);

            // ������� �� �� �����, ������� ��� � ini
            if (sizeof($to_delete)) {
                $qry = "DELETE `ca` FROM `sys_classes_actions` `ca`, `sys_actions` `a` WHERE `a`.`id` = `ca`.`action_id` AND `ca`.`class_id` = " . $data['c_id'] . " AND `a`.`name` IN ('" . implode("', '", $to_delete) . "')";
                $db->query($qry);
            }

            // ��������� � �� �����, ������� � �� ���
            if (sizeof($to_insert)) {
                // ��������� - ���������� �� ������ ����������� �����
                $names_needle = '';
                foreach ($to_insert as $val) {
                    $names_needle .= "" . $db->quote($val) . ", ";
                }
                $names_needle = substr($names_needle, 0, -2);

                $qry = "SELECT * FROM `sys_actions` WHERE `name` IN (" . $names_needle . ")";

                $exists_in_db = array();
                $stmt = $db->query($qry);
                while ($row = $stmt->fetch()) {
                    $exists_in_db[$row['id']] = $row['name'];
                }

                // ��������� ��, ������� ��� �� ���������� � sys_actions
                $actions_to_add = array_diff($to_insert, $exists_in_db);

                foreach ($actions_to_add as $val) {
                    $qry = "INSERT INTO `sys_actions` (`name`) VALUES (" . $db->quote($val) . ")";
                    $db->query($qry);
                    $exists_in_db[$db->lastInsertId()] = $val;
                }

                // ��������� ����� � ������
                $insert_string = '';
                foreach (array_keys($exists_in_db) as $val) {
                    $insert_string .= '(' . $data['c_id'] . ', ' . $val . '), ';
                }

                $qry = 'INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES ' . substr($insert_string, 0, -2);
                $db->query($qry);
            }

            return '���������� ������� ���������';
        } else {
            return '��� ������� �� �� ������ ���� � �������';
        }
    }
}

?>