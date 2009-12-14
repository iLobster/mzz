<?php

class adminGeneratorMapper extends mapper
{
    protected $table = 'admin';

    /**
     * Create module
     *
     * @param string $name
     * @param string $path
     * @return simpleModule
     */
    public function createModule($name, $path)
    {
        fileLoader::load('codegenerator/directoryGenerator');
        fileLoader::load('codegenerator/fileGenerator');

        $generator = new directoryGenerator($path);

        $generator->create($name);
        $generator->create($name . '/actions');
        $generator->create($name . '/controllers');
        $generator->create($name . '/i18n');
        $generator->create($name . '/mappers');
        $generator->create($name . '/models');
        $generator->create($name . '/templates');

        $generator->run();

        $moduleFileName = $name . 'Module.php';

        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();

        $leftDelimeter = $smarty->left_delimiter;
        $rightDelimeter = $smarty->right_delimiter;

        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        $smarty->assign('name', $name);
        $moduleContents = $smarty->fetch('admin/generator/module.tpl');

        $fileGenerator = new fileGenerator($path . '/' . $name);
        $fileGenerator->create($moduleFileName, $moduleContents);
        $fileGenerator->run();

        $smarty->left_delimiter = $leftDelimeter;
        $smarty->right_delimiter = $rightDelimeter;

        return $toolkit->getModule($name);
    }

    /**
     * Delete module
     *
     * @param simpleModule $module
     */
    public function deleteModule(simpleModule $module)
    {
        fileLoader::load('codegenerator/directoryGenerator');

        $currentDestination = current($this->getDests(true, $module->getName()));
        $currentDestination = pathinfo($currentDestination, PATHINFO_DIRNAME);

        $generator = new directoryGenerator($currentDestination);
        $generator->delete($module->getName(), array('recursive', 'skip'));
        $generator->run();
    }

    /**
     * Module class creation
     *
     * @param simpleModule $module
     * @param string $name
     * @param string $table
     * @param string $path
     */
    public function createClass(simpleModule $module, $name, $table, $path)
    {
        fileLoader::load('codegenerator/fileRegexpSearchReplaceTransformer');
        fileLoader::load('codegenerator/fileGenerator');
        $fileGenerator = new fileGenerator($path);

        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();

        $leftDelimeter = $smarty->left_delimiter;
        $rightDelimeter = $smarty->right_delimiter;

        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        $smarty->assign('module', $module);
        $smarty->assign('name', $name);
        $smarty->assign('table', $table);

        $doFileName = $this->generateDOFileName($name);
        $doContents = $smarty->fetch('admin/generator/do.tpl');

        $fileGenerator->create($doFileName, $doContents);

        try {
            $schema = $this->getTableSchema($table);
            $map = $this->mapFieldsFormatter($schema);
            $map_str = $this->generateMapString($map);
        } catch (PDOException $e) {
            $map_str = 'array()';
        }

        $smarty->assign('map', $map_str);
        $mapperFileName = $this->generateMapperFileName($name);
        $mapperContents = $smarty->fetch('admin/generator/mapper.tpl');
        $fileGenerator->create($mapperFileName, $mapperContents);

        $actions_string = var_export(array(), true);

        $actions_string = preg_replace('/^( +)/m', '$1$1', $actions_string);
        $actions_string = trim($actions_string);

        $smarty->assign('actions_string', $actions_string);
        $actionFileName = $this->generateActionFileName($name);
        $actionContents = $smarty->fetch('admin/generator/actions.tpl');
        $fileGenerator->create($actionFileName, $actionContents);

        $smarty->left_delimiter = $leftDelimeter;
        $smarty->right_delimiter = $rightDelimeter;

        $classes = $module->getClasses();
        $classes[] = $name;

        $fileGenerator->edit($module->getName() . 'Module.php', new fileRegexpSearchReplaceTransformer('/protected \$classes = array\s*\(.*?\);[\r\n]+/s', 'protected $classes = array(\'' . join("', '", $classes) . '\');' . "\r\n"));

        $fileGenerator->run();
    }

    /**
     * Delete class of module
     *
     * @param simpleModule $module
     * @param string $class_name
     * @param string $path
     */
    public function deleteClass(simpleModule $module, $class_name, $path)
    {
        fileLoader::load('codegenerator/fileGenerator');
        fileLoader::load('codegenerator/fileRegexpSearchReplaceTransformer');
        $fileGenerator = new fileGenerator($path);

        $classes = $module->getClasses();
        $class_index = array_search($class_name, $classes);
        if ($class_index !== false) {
            unset($classes[$class_index]);
        }

        $classString = '';
        if (sizeof($classes)) {
            $classString = '\'' . join("', '", $classes) . '\'';
        }

        $fileGenerator->edit($module->getName() . 'Module.php', new fileRegexpSearchReplaceTransformer('/protected \$classes = array\s*\(.*?\);[\r\n]+/s', 'protected $classes = array(' . $classString . ');' . "\r\n"));

        $fileGenerator->delete($this->generateActionFileName($class_name), array('ignore'));
        $fileGenerator->delete($this->generateMapperFileName($class_name), array('ignore'));
        $fileGenerator->delete($this->generateDOFileName($class_name), array('ignore'));

        $fileGenerator->run();
    }

    /**
     * Save action info
     *
     * @param simpleModule $module
     * @param string $class_name
     * @param string $action_name
     * @param array $actionData
     * @param string $path
     * @param bool $isEdit
     */
    public function saveAction(simpleModule $module, $class_name, $action_name, Array $actionData, $path, $isEdit, $crud_class_name = null)
    {
        fileLoader::load('codegenerator/fileGenerator');

        if (empty($actionData['controller'])) {
            $actionData['controller'] = $action_name;
        }

        if (isset($actionData['main']) && $actionData['main'] == simpleAction::DEFAULT_ACTIVE_TPL) {
            unset($actionData['main']);
        }

        if (isset($actionData['crud'])) {
            $crud = $actionData['crud'];
            unset($actionData['crud']);
        } else {
            $crud = null;
        }

        $actionFileName = $this->generateActionFileName($class_name);
        $actionFile = $path . '/' . $actionFileName;

        $actionsArray = include $actionFile;
        if (isset($actionsArray[$action_name]) && is_array($actionsArray[$action_name])) {
            $actionData = array_merge($actionsArray[$action_name], $actionData);
        }
        $actionsArray[$action_name] = $actionData;

        $fileGenerator = new fileGenerator($path);

        if (!$isEdit) {
            $toolkit = systemToolkit::getInstance();
            $smarty = $toolkit->getSmarty();

            $leftDelimeter = $smarty->left_delimiter;
            $rightDelimeter = $smarty->right_delimiter;

            $smarty->left_delimiter = '{{';
            $smarty->right_delimiter = '}}';

            $smarty->assign('module', $module);
            $smarty->assign('name', $class_name);
            $smarty->assign('actionsArray', $actionsArray);

            $controllerFileName = $this->generateControllerFileName($module, $actionData['controller']);
            $smarty->assign('actionData', $actionData);
            $smarty->assign('action_name', $action_name);

            $templateFileName = $this->generateTemplateFileName($action_name);
            $smarty->assign('path', $path);
            $smarty->assign('templateFileName', $templateFileName);

            switch ($crud) {
                case 'view':
                    $mapper = $toolkit->getMapper($module->getName(), $class_name);
                    $map = $this->getMapForCRUD($mapper);
                    $smarty->assign('map', $map);

                    $controllerContents = $smarty->fetch('admin/generator/controller.view.tpl');
                    $templateContents = $smarty->fetch('admin/generator/template.view.tpl');

                    $fileGenerator->create($controllerFileName, $controllerContents);
                    $fileGenerator->create($templateFileName, $templateContents);
                    break;

                case 'delete':
                    $controllerContents = $smarty->fetch('admin/generator/controller.delete.tpl');
                    $fileGenerator->create($controllerFileName, $controllerContents);

                    if (empty($actionData['jip'])) {
                        $actionData['jip'] = true;
                    }

                    if (empty($actionData['confirm'])) {
                        $actionData['confirm'] = '_ ' . $module->getName() . '/' . $class_name . '.delete.confirm';
                    }

                    if (empty($actionData['icon'])) {
                        $actionData['icon'] = 'sprite:mzz-icon/page-text/del';
                    }
                    if (empty($actionData['main'])) {
                        $actionData['main'] = 'active.blank.tpl';
                    }
                    $actionsArray[$action_name] = $actionData;

                    break;

                case 'list':
                    $mapper = $toolkit->getMapper($module->getName(), $class_name);
                    $map = $this->getMapForCRUD($mapper);
                    $smarty->assign('map', $map);

                    $controllerContents = $smarty->fetch('admin/generator/controller.list.tpl');
                    $templateContents = $smarty->fetch('admin/generator/template.list.tpl');

                    $fileGenerator->create($controllerFileName, $controllerContents);
                    $fileGenerator->create($templateFileName, $templateContents);
                    break;

                case 'save':
                    $crud_class_name = $crud_class_name ? $crud_class_name : $class_name;
                    $mapper = $toolkit->getMapper($module->getName(), $crud_class_name);
                    $smarty->assign('name', $crud_class_name);
                    $map = $this->getMapForCRUD($mapper);
                    $smarty->assign('map', $map);

                    $controllerContents = $smarty->fetch('admin/generator/controller.save.tpl');
                    $templateContents = $smarty->fetch('admin/generator/template.save.tpl');

                    $fileGenerator->create($controllerFileName, $controllerContents);
                    $fileGenerator->create($templateFileName, $templateContents);
                    break;

                default:
                    $controllerContents = $smarty->fetch('admin/generator/controller.tpl');
                    $templateContents = $smarty->fetch('admin/generator/template.tpl');

                    $fileGenerator->create($controllerFileName, $controllerContents);
                    $fileGenerator->create($templateFileName, $templateContents);
                    break;
            }

            $smarty->left_delimiter = $leftDelimeter;
            $smarty->right_delimiter = $rightDelimeter;
        }

        $this->addSaveActionsInGenerator($module, $class_name, $actionsArray, $fileGenerator);

        $fileGenerator->run();
    }

    /**
     * Delete action
     *
     * @param simpleModule $module
     * @param simpleAction $action
     * @param string $path
     */
    public function deleteAction(simpleModule $module, simpleAction $action, $path)
    {
        fileLoader::load('codegenerator/fileGenerator');
        $fileGenerator = new fileGenerator($path);

        $actionFileName = $this->generateActionFileName($action->getClassName());
        $actionFile = $path . '/' . $actionFileName;

        $actionsArray = include $actionFile;
        unset($actionsArray[$action->getName()]);

        $this->addSaveActionsInGenerator($module, $action->getClassName(), $actionsArray, $fileGenerator);

        $fileGenerator->delete($this->generateControllerFileName($module, $action->getControllerName()), array('ignore'));
        $fileGenerator->delete($this->generateTemplateFileName($action->getName()), array('ignore'));

        $fileGenerator->run();
    }

    /**
     * Add generator's scenario for action config file content
     *
     * @param simpleModule $module
     * @param string $class_name
     * @param array $actionsArray
     * @param fileGenerator $fileGenerator
     */
    protected function addSaveActionsInGenerator(simpleModule $module, $class_name, Array $actionsArray, fileGenerator &$fileGenerator)
    {
        fileLoader::load('codegenerator/fileFullReplaceTransformer');

        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();

        $leftDelimeter = $smarty->left_delimiter;
        $rightDelimeter = $smarty->right_delimiter;

        $smarty->assign('module', $module);
        $smarty->assign('name', $class_name);
        //$smarty->assign('actionsArray', $actionsArray);

        $smarty->left_delimiter = '{{';
        $smarty->right_delimiter = '}}';

        $actions_string = var_export($actionsArray, true);

        $actions_string = preg_replace('/^( +)/m', '$1$1', $actions_string);
        $actions_string = trim($actions_string);

        $smarty->assign('actions_string', $actions_string);

        $actionContents = $smarty->fetch('admin/generator/actions.tpl');

        $smarty->left_delimiter = $leftDelimeter;
        $smarty->right_delimiter = $rightDelimeter;

        $actionFileName = $this->generateActionFileName($class_name);
        $fileGenerator->edit($actionFileName, new fileFullReplaceTransformer($actionContents));
    }

    /**
     * Получение списка каталогов, используемых для генерации модулей
     *
     * @param boolean $onlyWritable показывать только те, для которых есть права на запись
     * @param string $subfolder подкаталог в каталоге modules, права на запись в который будет проверяться
     * @return array
     */
    public function getDests($onlyWritable = false, $subfolder = '')
    {
        if ($onlyWritable) {
            $dest = $this->getDests(false, $subfolder);

            foreach ($dest as $key => $val) {
                if (!is_writable($val)) {
                    unset($dest[$key]);
                }
            }

            return $dest;
        }

        return array(
        'sys' => systemConfig::$pathToSystem . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder,
        'app' => systemConfig::$pathToApplication . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $subfolder);
    }

    public function getTableSchema($table)
    {
        $table = substr($this->db()->quote($table), 1, -1);

        $result = array();
        foreach ($this->db()->getAll('SHOW COLUMNS FROM `' . $table . '`') as $field) {
            $key = $field['Field'];

            if (preg_match('/^([^(]+)(?:\((\d+)\)\s?(.*))?$/', $field['Type'], $matches)) {
                $result[$key] = array(
                    'accessor' => '',
                    'mutator' => '',
                    'type' => $matches[1]
                );
                if ($matches[1] == 'int') {
                    $result[$key]['range'] = $matches[3] ? array(0, pow(2, 32)) : array(-pow(2, 31) + 1, pow(2, 31));
                } elseif ($matches[1] == 'char' || $matches[1] == 'varchar') {
                    $result[$key]['maxlength'] = (int)$matches[2];
                }
            }
        }

        $row = $this->db()->getRow('SHOW CREATE TABLE `' . $table . '`');
        if (preg_match('/primary key\s+\(`([^`]+)`/si', $row['Create Table'], $matches)) {
            $result[$matches[1]]['options'][] = 'pk';
        }

        return $result;
    }

    public function mapFieldsFormatter($map)
    {
        foreach ($map as $key => & $value) {
            $key = explode('_', $key);
            $key = array_map('ucfirst', $key);
            $key = implode('', $key);

            $value['accessor'] = 'get' . $key;
            $value['mutator'] = 'set' . $key;

            if (isset($value['options']) && in_array('pk', $value['options'])) {
                $value['options'][] = 'once';
            }
        }

        return $map;
    }

    public function generateMapString($map)
    {
        $map_str = var_export($map, true);

        $map_str = preg_replace('/^( +)/m', '$1$1', $map_str);
        $map_str = preg_replace('/^/m', str_repeat(' ', 4) . '\\1', $map_str);
        $map_str = trim($map_str);

        return $map_str;
    }

    protected function getMapForCRUD(mapper $mapper)
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

    public function generateMapperFileName($class_name)
    {
        return 'mappers/' . $class_name . 'Mapper.php';
    }

    public function generateDOFileName($class_name)
    {
        return 'models/' . $class_name . '.php';
    }

    public function generateActionFileName($class_name)
    {
        return 'actions/' . $class_name . '.php';
    }

    public function generateControllerFileName(simpleModule $module, $name)
    {
        return 'controllers/' . $module->getName() . ucfirst($name) . 'Controller.php';
    }

    public function generateTemplateFileName($action_name)
    {
        return 'templates/' . $action_name . '.tpl';
    }
}

?>