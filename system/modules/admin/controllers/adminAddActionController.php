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
        // @todo: сделать автоматическое добавление/удаление действий и свойств по наличию нужных плагинов (например acl, i18n)

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
                $controller = new messageController('У выбранного класса нет запрашиваемого экшна', messageController::WARNING);
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

        return $this->smarty->fetch('admin/addAction.tpl');
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

class aaadminAddActionController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');
        $action_name = $this->request->getString('action_name');

        $action = $this->request->getAction();

        $db = DB::factory();

        $data = $db->getRow('SELECT `c`.`id` AS `c_id`, `m`.`id` AS `m_id`, `c`.`name` AS `c_name`, `m`.`name` AS `m_name` FROM `sys_classes` `c` INNER JOIN `sys_modules` `m` ON `m`.`id` = `c`.`module_id` WHERE `c`.`id` = ' . $id);
        if ($data === false) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $act = new action($data['m_name']);
        $info = $act->getActions();

        if ($action == 'editAction' && !isset($info[$data['c_name']][$action_name])) {
            $controller = new messageController('У выбранного класса нет запрашиваемого экшна', messageController::WARNING);
            return $controller->run();
        }

        $isEdit = $action == 'editAction';

        $actionsInfo = $info[$data['c_name']];

        // НАЧАЛО ВАЛИДАТОРА
        $url = new url('withId');
        $url->setAction($action);
        $url->add('id', $data['c_id']);
        if ($isEdit) {
            $url->setRoute('adminAction');
            $url->add('action_name', $action_name);
        }

        $defaults = new arrayDataspace();

        if ($isEdit) {
            $defaults->set('name', $action_name);

            $default = array(
            'title' => '',
            'info' => '',
            'icon' => '',
            '403handle' => '',
            'lang' => 0);

            $info = $actionsInfo[$action_name];
            $info = array_merge($default, $info);

            $defaults->set('controller', $info['controller']);
            $defaults->set('title', $info['title']);
            $defaults->set('icon', $info['icon']);
            $defaults->set('403handle', $info['403handle']);
            $defaults->set('lang', $info['lang']);

            if (isset($info['confirm'])) {
                $defaults->set('confirm', $info['confirm']);
            }
            if (isset($info['alias'])) {
                $defaults->set('alias', $info['alias']);
            }
            $defaults->set('jip', !empty($info['jip']));
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

        $aclMethods = array(
        'manual' => 'manual (ручной)',
        'none' => 'none (отключить)');

        $validator = new formValidator();
        $validator->add('required', 'action[name]', 'Поле обязательно к заполнению');
        $validator->add('callback', 'action[name]', 'Такое действие у класса уже есть или введённое вами имя содержит запрещённые символы', array(
        array(
        $this,
        'addClassValidate'),
        $db,
        $action_name,
        $data));
        $validator->add('callback', 'action[name]', 'Такое действие уже создано в приложении, но с другим регистром символов. Назовите текущий в таком же регистре, или выбериту другое имя', array(
        array(
        $this,
        'checkActionNameRegister'),
        $db,
        $action_name));

        // КОНЕЦ ВАЛИДАТОРА


        if ($validator->validate()) {
            $values = $this->request->getArray('action', SC_POST);
            $values['name'] = trim($values['name']);

            $modules = $adminMapper->getModulesList();

            if (empty($values['dest'])) {
                $file = fileLoader::resolve($modules[$data['m_id']]['name'] . '/actions/' . $data['c_name'] . '.ini');

                foreach ($dest as $key => $val) {
                    if (strpos($file, $val) === 0) {
                        $values['dest'] = $key;
                        break;
                    }
                }
            }

            $templates = $values['controller_template'];

            if (!empty($templates)) {
                $templates = unserialize(base64_decode($templates));
            }

            $dest = $adminMapper->getDests();
            $actionGenerator = new actionGenerator($modules[$data['m_id']]['name'], $dest[$values['dest']], $data['c_name'], $templates);

            if (!$isEdit) {
                try {
                    $log = $actionGenerator->generate($values['name'], $values);
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $actionGenerator->addToDB($values['name']);
            } else {
                $log = $actionGenerator->rename($action_name, $values['name'], $values);
            }

            $this->smarty->assign('isEdit', $isEdit);
            $this->smarty->assign('log', $log);
            $this->smarty->assign('name', $values['name']);

            return $this->smarty->fetch('admin/addActionResult.tpl');
        }

        // templates
        $templates = $this->searchTemplates();
        $tpl_options = array();
        foreach ($templates as $name => $tpl) {
            $value = base64_encode(serialize($tpl));
            $about = $name . ' (контроллер';
            if (isset($tpl['template'])) {
                $about .= '+ шаблон';
            }
            $tpl_options[$value] = $about . ')';
            $this->smarty->assign('templates', $tpl_options);
        }

        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('data', $data);
        $this->smarty->assign('action', $action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('aliases', $aliases);
        $this->smarty->assign('aclMethods', $aclMethods);
        $this->smarty->assign('dests', $dest);
        $this->smarty->assign('defaults', $defaults);

        return $this->smarty->fetch('admin/addAction.tpl');
    }

    public function searchTemplates()
    {
        $code_gen = systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'codegenerator';
        $path = $code_gen . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
        $tpl_dir = 'controller_templates' . DIRECTORY_SEPARATOR;

        $action_tpls = array();
        foreach (glob($path . $tpl_dir . '*.tpl') as $tpl) {
            $tpl_info = pathinfo($tpl);
            // pathinfo() fix for php < 5.2.0
            if (!isset($tpl_info['filename'])) {
                $tpl_info['filename'] = substr($tpl_info['basename'], 0, -(1 + strlen($tpl_info['extension'])));
            }
            $file_name = $tpl_info['filename'];
            if (!is_int(strpos($file_name, '.')))
            continue;
            list ($action, $type) = explode('.', $file_name);
            $action_tpls[$action][$type] = $tpl_dir . $tpl_info['basename'];
        }

        return $action_tpls;
    }

    public function addClassValidate($name, $db, $action_name, $data)
    {
        if (strlen($name) === 0 || preg_match('/[^a-z0-9_\-]/i', $name)) {
            return false;
        }

        if ($name == $action_name) {
            return true;
        }

        return !$db->getOne('SELECT COUNT(*) AS `cnt` FROM `sys_classes_actions` `ca`
                               INNER JOIN `sys_actions` `a` ON `a`.`id` = `ca`.`action_id`
                                WHERE `ca`.`class_id` = ' . $data['c_id'] . ' AND `a`.`name` = ' . $db->quote($name));
    }

    public function checkActionNameRegister($name, $db, $action_name)
    {
        $name_in_db = $db->getOne('SELECT `name` FROM `sys_actions`
                                WHERE `name` = ' . $db->quote($name));

        return !$name_in_db || $name_in_db == $name;
    }

}

?>