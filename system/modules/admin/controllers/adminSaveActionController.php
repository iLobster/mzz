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

fileLoader::load('codegenerator/fileGenerator');
fileLoader::load('codegenerator/fileIniTransformer');
fileLoader::load('codegenerator/fileSearchReplaceTransformer');

/**
 * adminSaveActionController: контроллер для метода addAction|editAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminSaveActionController extends simpleController
{
    private $plugins = array();

    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $action_name = $this->request->getString('action_name');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = $action == 'editAction';

        $class = $adminMapper->searchClassById($id);

        if ($class === false) {
            $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $module = $adminMapper->searchModuleById($class['module_id']);

        $act = new action($module['name']);
        $actions = $act->getActions();

        if ($isEdit) {
            if (!isset($actions[$class['name']][$action_name])) {
                $controller = new messageController(i18n::getMessage('action.error.not_exists', 'admin'), messageController::WARNING);
                return $controller->run();
            }
        }

        $actionsInfo = $actions[$class['name']];

        $dests = $adminGeneratorMapper->getDests(true, $module['name']);

        if (!sizeof($dests)) {
            $controller = new messageController(i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $defaults = $this->getDefaults($module['name'], $class['name']);
        $data = $defaults;

        if ($isEdit) {
            $data = array_merge($data, $actionsInfo[$action_name]);
            $data['name'] = $action_name;
        }

        $validator = new formValidator();

        $validator->add('required', 'action[name]', i18n::getMessage('action.error.name_required', 'admin'));
        $validator->add('callback', 'action[name]', i18n::getMessage('action.error.unique', 'admin'), array(
            array(
                $this,
                'unique'),
            $adminMapper,
            $action_name,
            $class['id']));
        $validator->add('callback', 'action[name]', i18n::getMessage('action.error.case', 'admin'), array(
            array(
                $this,
                'otherCase'),
            $adminMapper));
        $validator->add('regex', 'action[name]', i18n::getMessage('error.use_chars', 'admin', null, array(
            'a-zA-Z0-9_-')), '#^[a-z0-9_-]+$#i');
        $validator->add('required', 'action[main]', i18n::getMessage('action.error.main_required', 'admin'));
        $validator->add('regex', 'action[main]', i18n::getMessage('error.use_chars', 'admin', null, array(
            'a-zA-Z0-9_-.')), '#^[a-z0-9_\-.]+$#i');
        $validator->add('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));

        if ($validator->validate()) {
            $values = $this->request->getArray('action', SC_POST);
            $dest = $this->request->getString('dest', SC_POST);

            $values += $data;

            $this->normalize($values, $defaults);

            if (!$isEdit) {
                $action_name = $values['name'];

                $this->smartyBrackets();

                try {
                    $fileGenerator = new fileGenerator($dests[$dest]);

                    $controllerName = $dests[$dest] . DIRECTORY_SEPARATOR . $this->controllers($module['name'], $values['controller']);

                    if (!is_file($controllerName)) {
                        $crud = $values['crud'];
                        unset($values['crud']);

                        if ($crud != 'none') {
                            $method = 'crud' . ucfirst($crud);
                            $this->$method($module, $class, $values['controller'], $values, $fileGenerator);
                        } else {
                            $tpl_name = $this->templates($action_name);

                            $controllerData = array(
                                'name' => $values['controller'],
                                'module' => $module['name'],
                                'path' => $dest . '/' . $tpl_name);
                            $this->smarty->assign('controller_data', $controllerData);

                            $fileGenerator->create($this->controllers($module['name'], $values['controller']), $this->smarty->fetch('admin/generator/controller.tpl'));
                            $fileGenerator->create($tpl_name, $this->smarty->fetch('admin/generator/template.tpl'));
                        }
                    }

                    unset($values['name']);
                    $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array(
                        $action_name => $values)));

                    $fileGenerator->run();

                    $adminGeneratorMapper->createAction($action_name, $class['id']);
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $this->smartyBrackets(true);
            } else {
                $old = $actionsInfo[$action_name];

                $new_action_name = $values['name'];
                unset($values['name']);
                unset($values['crud']);

                try {
                    $fileGenerator = new fileGenerator($dests[$dest]);

                    if ($new_action_name != $action_name) {
                        // переименовать в файле с экшнами секцию
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('delete', $action_name));
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array(
                            $new_action_name => $values)));

                        if ($values['controller'] == $new_action_name) {
                            // изменить имя контроллера
                            $fileGenerator->edit($this->controllers($module['name'], $action_name), new fileSearchReplaceTransformer($module['name'] . ucfirst($action_name), $module['name'] . ucfirst($new_action_name)));
                            // изменить имя шаблона в контроллере
                            $fileGenerator->edit($this->controllers($module['name'], $action_name), new fileSearchReplaceTransformer($module['name'] . '/' . $action_name . '.tpl', $module['name'] . '/' . $new_action_name . '.tpl'));

                            // изменить контент шаблона
                            $tpl_name = $this->templates($new_action_name);
                            $controllerData = array(
                                'name' => $new_action_name,
                                'module' => $module['name'],
                                'path' => $dest . '/' . $tpl_name);
                            $this->smarty->assign('controller_data', $controllerData);
                            $fileGenerator->edit($this->templates($action_name), new fileSearchReplaceTransformer(null, $this->smarty->fetch('admin/generator/template.tpl')));

                            // переименовать шаблон
                            $fileGenerator->rename($this->templates($action_name), $tpl_name);

                            // переименовать контроллер
                            $fileGenerator->rename($this->controllers($module['name'], $action_name), $this->controllers($module['name'], $new_action_name));
                        }
                    }

                    if ($this->isDataChanged($old, $values)) {
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array(
                            $new_action_name => $values)));
                    }

                    $fileGenerator->run();

                    // изменить в базе (sys_actions, sys_classes_actions, sys_access)
                    $new_action_id = $adminGeneratorMapper->renameAction($action_name, $new_action_name, $class['id']);
                    if (in_array('acl', $this->plugins)) {
                        $acl = new acl();
                        $acl->renameAction($class['id'], $action_name, $new_action_id);
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }

            return jipTools::closeWindow();
        }

        $aliases = array();
        foreach ($actionsInfo as $key => $val) {
            if ($action_name != $key) {
                $aliases[$key] = isset($val['title']) ? i18n::getMessage($val['title'], $module['name']) : $key;
            }
        }
        $this->smarty->assign('aliases', $aliases);

        $this->smarty->assign('aclMethods', $this->getAclMethods());
        $this->smarty->assign('crudList', $this->getCRUDList());

        if ($isEdit) {
            $url = new url('adminAction');
            $url->add('action_name', $action_name);
        } else {
            $url = new url('withId');
        }
        $url->setAction($action);
        $url->add('id', $id);

        $this->smarty->assign('plugins', $this->plugins);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('data', $data);

        $this->smarty->assign('dests', $dests);

        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/saveAction.tpl');
    }

    private function crudView($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.view.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.view.tpl'));

        $fileGenerator->run();
    }

    private function crudDelete($module, $class, $action_name, & $values, $fileGenerator)
    {
        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.delete.tpl'));

        if (empty($values['jip'])) {
            $values['jip'] = true;
        }

        if (empty($values['confirm'])) {
            $values['confirm'] = '_ ' . $module['name'] . '/' . $class['name'] . '.delete.confirm';
        }

        if (empty($values['icon'])) {
            $values['icon'] = '/templates/images/delete.gif';
        }

        if (empty($values['main'])) {
            $values['main'] = 'active.blank.tpl';
        }

        $fileGenerator->run();
    }

    private function crudList($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.list.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.list.tpl'));

        $fileGenerator->run();
    }

    private function crudSave($module, $class, $action_name, $values, $fileGenerator)
    {
        $mapper = $this->toolkit->getMapper($module['name'], $class['name']);
        $map = $this->getMap($mapper);

        $controllerData = array(
            'name' => $action_name,
            'module' => $module['name'],
            'class' => $class['name']);
        $this->smarty->assign('controller_data', $controllerData);

        $this->smarty->assign('map', $map);

        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.save.tpl'));
        $fileGenerator->create($this->templates($action_name), $this->smarty->fetch('admin/generator/template.save.tpl'));

        $fileGenerator->run();
    }

    private function getMap(mapper $mapper)
    {
        $map = $mapper->map();

        $exclude = array_keys($mapper->getRelations()->oneToOneBack() + $mapper->getRelations()->manyToMany() + $mapper->getRelations()->oneToMany());

        foreach ($map as $key => $val) {
            if ((isset($val['options']) && (in_array('fake', $val['options']) || in_array('plugin', $val['options']))) || in_array($key, $exclude)) {
                unset($map[$key]);
            }
        }

        return $map;
    }

    public function unique($name, $adminMapper, $action_name, $class_id)
    {
        if ($name == $action_name) {
            return true;
        }

        return !$adminMapper->searchActionByNameAndClassId($name, $class_id);
    }

    public function otherCase($name, $adminMapper)
    {
        $action = $adminMapper->searchActionByName($name);

        if ($action) {
            return $action['name'] == $name;
        }

        return true;
    }

    private function isDataChanged($old, $values)
    {
        foreach ($values as $key => $value) {
            if (!isset($old[$key]) || $old[$key] != $value) {
                return true;
            }
        }

        return false;
    }

    private function getAclMethods()
    {
        $aclMethods = array(
            'none' => i18n::getMessage('action.acl.none', 'admin'));
        if (in_array('acl', $this->plugins)) {
            $aclMethods += array(
                'manual' => i18n::getMessage('action.acl.manual', 'admin'),
                'auto' => i18n::getMessage('action.acl.auto', 'admin'));
        }

        return $aclMethods;
    }

    private function getCRUDList()
    {
        $crud = array(
            'none' => 'none',
            'view' => 'view',
            'list' => 'list',
            'save' => 'save');

        if (in_array('jip', $this->plugins)) {
            $crud['delete'] = 'delete';
        }

        return $crud;
    }

    private function actions($name)
    {
        return 'actions/' . $name . '.ini';
    }

    private function templates($name)
    {
        return 'templates/' . $name . '.tpl';
    }

    private function controllers($module, $action)
    {
        return 'controllers/' . $module . ucfirst($action) . 'Controller.php';
    }

    private function getDefaults($module, $class)
    {
        $mapper = $this->toolkit->getMapper($module, $class);

        $defaults = array(
            'name' => '',
            'controller' => '',
            'confirm' => '',
            '403handle' => 'auto',
            'act_template' => '',
            'lang' => '',
            'crud' => 'none',
            'main' => 'active.main.tpl');

        if ($mapper->isAttached('jip')) {
            $defaults += array(
                'jip' => 0,
                'title' => '',
                'icon' => '');
            $this->plugins[] = 'jip';
        }

        if ($mapper->isAttached('acl_ext') || $mapper->isAttached('acl_simple')) {
            $defaults += array(
                'alias' => '');
            $this->plugins[] = 'acl';
        }

        return $defaults;
    }

    private function normalize(& $values, $defaults)
    {
        $exclude = array(
            'crud');

        foreach ($values as $key => & $val) {
            if (!isset($defaults[$key]) || ($defaults[$key] == $val && !in_array($key, $exclude))) {
                if (!preg_match('!^route[._].+!', $key)) {
                    unset($values[$key]);
                }
            }
        }

        if (empty($values['controller'])) {
            $values['controller'] = $values['name'];
        }
    }

    private function smartyBrackets($back = false)
    {
        if ($back) {
            $this->smarty->left_delimiter = '{';
            $this->smarty->right_delimiter = '}';
            return;
        }

        $this->smarty->left_delimiter = '{{';
        $this->smarty->right_delimiter = '}}';
    }
}

?>