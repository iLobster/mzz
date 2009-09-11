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

/**
 * adminSaveClassController: контроллер для метода addClass|editClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminSaveClassController extends simpleController
{
    protected function getView()
    {
        $id = $this->request->getInteger('id');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $adminGeneratorMapper = $this->toolkit->getMapper('admin', 'adminGenerator');

        $action = $this->request->getAction();
        $isEdit = $action == 'editClass';

        if ($isEdit) {
            $data = $adminMapper->searchClassById($id);

            if ($data === false) {
                $controller = new messageController(i18n::getMessage('class.error.not_exists', 'admin'), messageController::WARNING);
                return $controller->run();
            }

            $module = $adminMapper->searchModuleById($data['module_id']);

            $module_name = $module['name'];

            $mapper = $this->toolkit->getMapper($module_name, $data['name']);

            $data['table'] = $mapper->table();
        } else {
            $data = $adminMapper->searchModuleById($id);

            if ($data === false) {
                $controller = new messageController(i18n::getMessage('module.error.not_exists', 'admin'), messageController::WARNING);
                return $controller->run();
            }

            $module_name = $data['name'];
            $data['table'] = '';
        }

        $dests = $adminGeneratorMapper->getDests(true, $module_name);

        if (!sizeof($dests)) {
            $controller = new messageController(i18n::getMessage('error.write_denied', 'admin'), messageController::WARNING);
            return $controller->run();
        }

        $validator = new formValidator();

        $validator->add('required', 'name', i18n::getMessage('class.error.name_required', 'admin'));
        $validator->add('callback', 'name', i18n::getMessage('class.error.unique', 'admin'), array(array($this, 'checkUniqueClassName'), $adminMapper, $isEdit ? $data['name'] : ''));
        $validator->add('regex', 'name', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
        $validator->add('in', 'dest', i18n::getMessage('module.error.wrong_dest', 'admin'), array_keys($dests));

        if (!$isEdit) {
            $validator->add('required', 'table', i18n::getMessage('class.error.table_required', 'admin'));
            $validator->add('regex', 'table', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
        }

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $table = $this->request->getString('table', SC_POST);

            if (!$isEdit) {
                $this->smartyBrackets();

                $dest = $this->request->getString('dest', SC_POST);

                try {
                    try {
                        $schema = $adminGeneratorMapper->getTableSchema($table);
                        $map = $adminGeneratorMapper->mapFieldsFormatter($schema);
                        $map_str = $adminGeneratorMapper->generateMapString($map);
                    } catch (PDOException $e) {
                        $map_str = 'array()';
                    }

                    $fileGenerator = new fileGenerator($dests[$dest]);

                    $doData = array(
                        'name' => $name,
                        'module' => $module_name);
                    $this->smarty->assign('do_data', $doData);
                    $doContents = $this->smarty->fetch('admin/generator/do.tpl');
                    $fileGenerator->create($this->entity($name), $doContents);

                    $doData = array(
                        'name' => $name,
                        'module' => $module_name,
                        'table' => $table,
                        'map' => $map_str);
                    $this->smarty->assign('mapper_data', $doData);
                    $mapperContents = $this->smarty->fetch('admin/generator/mapper.tpl');
                    $fileGenerator->create($this->mappers($name), $mapperContents);

                    $fileGenerator->create($this->actions($name));

                    $fileGenerator->run();
                } catch (Exception $e) {
                    return $e->getMessage();
                }

                $class_id = $adminGeneratorMapper->createClass($name, $id);

                $this->smartyBrackets(true);

                $this->smarty->assign('id', $class_id);
                $this->smarty->assign('name', $name);
                $this->smarty->assign('module', $module_name);

                return $this->smarty->fetch('admin/addClassResult.tpl');
            }

            // @todo: написать трансформатор на изменение имён классов
            $fileGenerator = new fileGenerator($data['dest']);
            $fileGenerator->rename($this->actions($data['name']), $this->actions($name));
            $fileGenerator->rename($this->mappers($data['name']), $this->mappers($name));
            $fileGenerator->rename($this->entity($data['name']), $this->entity($name));
            $fileGenerator->run();

            $adminGeneratorMapper->renameClass($id, $name);

            return jipTools::redirect();
        }

        $url = new url('withId');
        $url->add('id', $data['id']);
        $url->setAction($action);

        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        if (!$isEdit) {
            $data['name'] = '';
        }
        $this->smarty->assign('data', $data);
        $this->smarty->assign('isEdit', $isEdit);

        $this->smarty->assign('dests', $dests);

        return $this->smarty->fetch('admin/saveClass.tpl');
    }

    private function actions($name)
    {
        return 'actions/' . $name . '.ini';
    }

    private function mappers($name)
    {
        return 'mappers/' . $name . 'Mapper.php';
    }

    private function entity($name)
    {
        return $name . '.php';
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

    public function checkUniqueClassName($name, $adminMapper, $class_name)
    {
        if ($name == $class_name) {
            return true;
        }

        $class = $adminMapper->searchClassByName($name);

        return !$class;
    }
}

?>