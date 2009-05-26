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
 * adminAddActionController: контроллер для метода addAction модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */

class adminAddActionController extends simpleController
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
                // @todo: перевести
                $controller = new messageController(i18n::getMessage('action.error.not_exists', 'admin'), messageController::WARNING);
                return $controller->run();
            }
        }

        $actionsInfo = $actions[$class['name']];

        $dest = current($adminGeneratorMapper->getDests(true, $module['name']));

        $defaults = $this->getDefaults($module['name'], $class['name']);
        $data = $defaults;

        if ($isEdit) {
            $data = array_merge($data, $actionsInfo[$action_name]);
            $data['name'] = $action_name;
        }

        $data['dest'] = $dest;

        $validator = new formValidator();

        $validator->add('required', 'action[name]', i18n::getMessage('action.error.name_required', 'admin'));
        $validator->add('callback', 'action[name]', i18n::getMessage('action.error.unique', 'admin'), array(array($this, 'unique'), $adminMapper, $action_name, $class['id']));
        $validator->add('callback', 'action[name]', i18n::getMessage('action.error.case', 'admin'), array(array($this, 'otherCase'), $adminMapper));
        $validator->add('regex', 'action[name]', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')), '#^[a-z0-9_-]+$#i');

        if ($validator->validate()) {
            $values = $this->request->getArray('action', SC_POST);

            $this->normalize($values, $defaults);

            if (!$isEdit) {
                $action_name = $values['name'];

                $this->smartyBrackets();

                try {
                    $fileGenerator = new fileGenerator($dest);

                    $tpl_name = $this->templates($action_name);

                    $controllerData = array(
                    'name' => $action_name,
                    'module' => $module['name'],
                    'path' => $dest . '/' . $tpl_name);
                    $this->smarty->assign('controller_data', $controllerData);

                    if ($values['controller'] == $action_name) {
                        $fileGenerator->create($this->controllers($module['name'], $action_name), $this->smarty->fetch('admin/generator/controller.tpl'));
                    }

                    $fileGenerator->create($tpl_name, $this->smarty->fetch('admin/generator/template.tpl'));

                    unset($values['name']);
                    $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array($action_name => $values)));

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

                try {
                    $fileGenerator = new fileGenerator($dest);

                    if ($new_action_name != $action_name) {
                        // переименовать в файле с экшнами секцию
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('delete', $action_name));
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array($new_action_name => $values)));

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
                        $fileGenerator->edit($this->actions($class['name']), new fileIniTransformer('merge', array($new_action_name => $values)));
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
                $aliases[$key] = isset($val['title']) ? $val['title'] : $key;
            }
        }
        $this->smarty->assign('aliases', $aliases);

        $this->smarty->assign('aclMethods', $this->getAclMethods());

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

        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/addAction.tpl');
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
        $aclMethods = array('none' => 'none (отключить)');
        if (in_array('acl', $this->plugins)) {
            $aclMethods += array(
            'manual' => 'manual (ручной)',
            'auto' => 'auto (автоматически)');
        }

        return $aclMethods;
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
        '403handle' => 'none',
        'act_template' => '');

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
        '403handle');

        foreach ($values as $key => & $val) {
            if (!isset($defaults[$key]) || ($defaults[$key] == $val && !in_array($key, $exclude))) {
                unset($values[$key]);
            }
        }

        if (empty($values['controller'])) {
            $values['controller'] = $values['name'];
        }

        //unset($values['name']);
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