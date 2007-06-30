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

fileLoader::load('codegenerator/actionGenerator');
fileLoader::load('forms/validators/formValidator');

/**
 * adminAddActionController: ���������� ��� ������ addAction ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.2
 */

class adminAddActionController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $action_name = $this->request->get('action_name', 'string', SC_PATH);

        $action = $this->request->getAction();

        $db = DB::factory();

        $data = $db->getRow('SELECT `c`.`id` AS `c_id`, `m`.`id` AS `m_id`, `c`.`name` AS `c_name`, `m`.`name` AS `m_name` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);
        if ($data === false) {
            $controller = new messageController('������ �� ����������', messageController::WARNING);
            return $controller->run();
        }

        $act = new action($data['m_name']);
        $info = $act->getActions();

        if ($action == 'editAction' && !isset($info[$data['c_name']][$action_name])) {
            $controller = new messageController('� ��������� ������ ��� �������������� �����', messageController::WARNING);
            return $controller->run();
        }

        $isEdit = $action == 'editAction';

        $actionsInfo = $info[$data['c_name']];
        //@todo ��������� ���� ��� ����� ������� � ��������� ����� ��� ��� ������ ���� � QF
        // ������ ����������
        $url = new url('withId');
        $url->setAction($action);
        $url->addParam('id', $data['c_id']);
        if ($isEdit) {
            $url->setRoute('adminAction');
            $url->addParam('action_name', $action_name);
        }

        $defaults = new arrayDataspace();

        if ($isEdit) {
            $defaults->set('name', $action_name);

            $default = array('title' => '', 'info' => '', 'icon' => '');

            $info = $actionsInfo[$action_name];
            $info = array_merge($default, $info);

            $defaults->set('controller', $info['controller']);
            $defaults->set('title', $info['title']);
            $defaults->set('icon', $info['icon']);

            if (isset($info['confirm'])) {
                $defaults->set('confirm', $info['confirm']);
            }
            if (isset($info['alias'])) {
                $defaults->set('alias', $info['alias']);
            }
            $defaults->set('jip', !empty($info['jip']));
            $defaults->set('inACL', isset($info['inACL']) && $info['inACL'] == 0);
        } else {
            $defaults->set('icon', '/templates/images/');
        }

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $dest = $adminMapper->getDests(true, $data['m_name']);

        foreach ($actionsInfo as $key => $val) {
            if ($action_name != $key) {
                $aliases[$key] = isset($val['title']) ? $val['title'] : $key;
            }
        }

        $validator = new formValidator();
        $validator->add('required', 'action[name]', '���� ����������� � ����������');
        $validator->add('callback', 'action[name]', '����� �������� � ������ ��� ���� ��� �������� ���� ��� �������� ����������� �������', array('addClassValidate', $db, $action_name, $data));

        // ����� ����������

        if ($validator->validate()) {
            $values = $this->request->get('action', 'array', SC_POST);

            $modules = $adminMapper->getModulesList();

            if (@!$values['dest']) {
                $file = fileLoader::resolve($modules[$data['m_id']]['name'] . '/actions/' . $data['c_name'] . '.ini');

                foreach ($dest as $key => $val) {
                    if (strpos($file, $val) === 0) {
                        $values['dest'] = $key;
                        break;
                    }
                }
            }

            $dest = $adminMapper->getDests();
            $actionGenerator = new actionGenerator($modules[$data['m_id']]['name'], $dest[$values['dest']], $data['c_name']);

            if (!$isEdit) {
                try {
                    $log = $actionGenerator->generate($values['name'], $values);
                } catch (Exception $e) {
                    return $e->getMessage() . $e->getLine() . $e->getFile();
                }

                $actionGenerator->addToDB($values['name']);
            } else {
                $actionGenerator->rename($action_name, $values['name'], $values);
            }

            return jipTools::closeWindow();
        }

        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('aliases', $aliases);
        $this->smarty->assign('dests', $dest);
        $this->smarty->assign('defaults', $defaults);

        return $this->smarty->fetch('admin/addAction.tpl');
    }
}

function addClassValidate($name, $db, $action_name, $data)
{
    if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
        return false;
    }

    if ($name == $action_name) {
        return true;
    }

    $res = $db->getRow('SELECT COUNT(*) AS `cnt` FROM `sys_classes_actions` `ca`
                   INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                    WHERE `ca`.`class_id` = ' . $data['c_id'] . ' AND `a`.`name` = ' . $db->quote($name));

    return $res['cnt'] == 0;
}

?>