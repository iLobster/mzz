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
 * adminListActionsController: контроллер для метода listActions модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.3
 */

class adminListActionsController extends simpleController
{
    protected function getView()
    {
        $this->db = DB::factory();

        $id = $this->request->getInteger('id');

        $data = $this->db->getRow('SELECT `c`.`name` AS `c_name`, `c`.`id` AS `c_id`, `m`.`name` AS `m_name`, `m`.`id` AS `m_id` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);
        if ($data === false) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $actions_db = $this->getActions($id);
        $this->removeEditACL($actions_db);

        $deleted = $inserted = array();

        // выбираем все экшны для данного ДО из INI-файла
        $action = new action($data['m_name']);
        $tmp = $action->getActions(array('acl' => true));

        if (isset($tmp[$data['c_name']])) {
            $actions_ini = array_keys($tmp[$data['c_name']]);
            $this->removeEditACL($actions_ini);

            $to_delete = array_diff($actions_db, $actions_ini);
            $to_insert = array_diff($actions_ini, $actions_db);

            // удаляем из БД экшны, которых нет в ini
            if (sizeof($to_delete)) {
                $qry = "DELETE `ca` FROM `sys_classes_actions` `ca`, `sys_actions` `a` WHERE `a`.`id` = `ca`.`action_id` AND `ca`.`class_id` = " . $data['c_id'] . " AND `a`.`name` IN ('" . implode("', '", $to_delete) . "')";
                $this->db->query($qry);
            }

            $exists_in_db = array();
            // добавляем в БД экшны, которых в БД нет
            if (sizeof($to_insert)) {
                // проверяем - существуют ли вообще добавляемые экшны
                $names_needle = '';
                foreach ($to_insert as $val) {
                    $names_needle .= "" . $this->db->quote($val) . ", ";
                }
                $names_needle = substr($names_needle, 0, -2);

                $qry = "SELECT * FROM `sys_actions` WHERE `name` IN (" . $names_needle . ")";

                $stmt = $this->db->query($qry);
                while ($row = $stmt->fetch()) {
                    $exists_in_db[$row['id']] = $row['name'];
                }

                // добавляем те, которые еще не существуют в sys_actions
                $actions_to_add = array_diff($to_insert, $exists_in_db);

                foreach ($actions_to_add as $val) {
                    $qry = "INSERT INTO `sys_actions` (`name`) VALUES (" . $this->db->quote($val) . ")";
                    $this->db->query($qry);
                    $exists_in_db[$this->db->lastInsertId()] = $val;
                }

                // добавляем экшны к классу
                $insert_string = '';
                foreach (array_keys($exists_in_db) as $val) {
                    $insert_string .= '(' . $data['c_id'] . ', ' . $val . '), ';
                }

                $qry = 'INSERT INTO `sys_classes_actions` (`class_id`, `action_id`) VALUES ' . substr($insert_string, 0, -2);
                $this->db->query($qry);
            }

            $action = new action($data['m_name']);
            $tmp = $action->getActions();
            $tmp = $tmp[$data['c_name']];
            $this->removeEditACL($tmp);

            $this->smarty->assign('id', $id);
            $this->smarty->assign('actions', $tmp);
            $this->smarty->assign('insert', $exists_in_db);
            $this->smarty->assign('delete', $to_delete);
            return $this->smarty->fetch('admin/listActions.tpl');
        } else {
            return 'Для данного ДО не найден файл с экшнами';
        }
    }

    private function getActions($id)
    {
        $qry = 'SELECT `a`.`name`, `a`.`id` FROM `sys_classes_actions` `ca`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = ' . $id;
        $stmt = $this->db->query($qry);

        $actions_db = array();
        while ($row = $stmt->fetch()) {
            $actions_db[] = $row['name'];
        }

        return $actions_db;
    }

    private function removeEditACL(&$arr)
    {
        if (($key = array_search('editACL', $arr)) !== false) {
            unset($arr[$key]);
        }

        if (($key = array_search('editDefault', $arr)) !== false) {
            unset($arr[$key]);
        }

        if (isset($arr['editACL'])) {
            unset($arr['editACL']);
        }

        if (isset($arr['editDefault'])) {
            unset($arr['editDefault']);
        }
    }
}

?>