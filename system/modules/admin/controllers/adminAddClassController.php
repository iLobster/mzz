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
 * adminAddClassController: контроллер для метода addClass модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.3
 */
class adminAddClassController extends simpleController
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

        $data['dest'] = current($adminGeneratorMapper->getDests(true, $module_name));

        $validator = new formValidator();

        $validator->add('required', 'name', i18n::getMessage('class.error.name_required', 'admin'));
        $validator->add('callback', 'name', i18n::getMessage('class.error.unique', 'admin'), array(array($this, 'checkUniqueClassName'), $adminMapper, $isEdit ? $data['name'] : ''));
        $validator->add('regex', 'name', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');

        if (!$isEdit) {
            $validator->add('required', 'table', i18n::getMessage('class.error.table_required', 'admin'));
            $validator->add('regex', 'table', i18n::getMessage('error.use_chars', 'admin', null, array('a-zA-Z0-9_-')) , '#^[a-z0-9_-]+$#i');
        }

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $table = $this->request->getString('table', SC_POST);

            if (!$isEdit) {
                $this->smartyBrackets();

                try {
                    $fileGenerator = new fileGenerator($data['dest']);

                    $doData = array(
                        'name' => $name,
                        'module' => $module_name);
                    $this->smarty->assign('do_data', $doData);
                    $doContents = $this->smarty->fetch('admin/generator/do.tpl');
                    $fileGenerator->create($this->entity($name), $doContents);

                    $doData = array(
                        'name' => $name,
                        'module' => $module_name,
                        'table' => $table);
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

        return $this->smarty->fetch('admin/addClass.tpl');
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