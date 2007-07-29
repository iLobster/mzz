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

fileLoader::load('forms/validators/formValidator');
fileLoader::load('service/iniFIle');

/**
 * adminSavemapController: контроллер для редактирования полей map-файла
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

class adminSavemapController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = $action == 'editmap';

        $class_name = $this->request->get(!$isEdit ? 'name' : 'class', 'string');
        $field_name = $this->request->get('field', 'string');

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $class = $adminMapper->searchClassByName($class_name);

        if (!$class) {
            $controller = new messageController('Класса не существует', messageController::WARNING);
            return $controller->run();
        }

        $adminMapper = $this->toolkit->getMapper('admin', 'admin');
        $module = $adminMapper->searchModuleByClassId($class['id']);

        $mapfile_name = $module['name'] . '/maps/' . $class['name'] . '.map.ini';
        $file = new iniFile(fileLoader::resolve($mapfile_name));
        $mapfile = $file->read();

        if ($isEdit && !isset($mapfile[$field_name])) {
            $controller = new messageController('У выбранного класса не существует поля ' . $field_name, messageController::WARNING);
            return $controller->run();
        }

        $directions = array('asc' => 'А-Я', 'desc' => 'Я-А');

        $validator = new formValidator();

        if (!$isEdit) {
            $validator->add('required', 'field[name]', 'Поле обязательно к заполнению');
            $validator->add('regex', 'field[name]', 'Недопустимые символы в имени', '/^[a-z0-9_]+$/i');
            $validator->add('callback', 'field[name]', 'Поле с таким именем уже есть у данного ДО', array('addMapNameValidate', $mapfile));
        }

        $validator->add('required', 'field[accessor]', 'Поле обязательно к заполнению');
        $validator->add('callback', 'field[accessor]', 'Такое имя акцессора уже используется', array('addMapMethodValidate', $mapfile, $isEdit ? $field_name : ''));
        $validator->add('equal', 'field[accessor]', 'Имена акцессора и мутатора должны быть разными', array('field[mutator]', false));
        $validator->add('required', 'field[mutator]', 'Поле обязательно к заполнению');
        $validator->add('callback', 'field[mutator]', 'Такое имя мутатора уже используется', array('addMapMethodValidate', $mapfile, $isEdit ? $field_name : ''));
        $validator->add('range', 'field[orderBy]', 'Значение должно быть положительным', range(1, null));

        if ($validator->validate()) {
            $values = $this->request->get('field', 'array', SC_POST);

            if (!$isEdit) {
                $mapfile[$values['name']] = array();
                $field_name = $values['name'];
            }

            $mapfile[$field_name]['accessor'] = $values['accessor'];
            $mapfile[$field_name]['mutator'] = $values['mutator'];

            if (isset($values['once'])) {
                if ($values['once']) {
                    $mapfile[$field_name]['once'] = $values['once'];
                } elseif (isset($mapfile[$field_name]['once'])) {
                    unset($mapfile[$field_name]['once']);
                }
            }

            if (isset($values['orderBy'])) {
                if ($values['orderBy']) {
                    $mapfile[$field_name]['orderBy'] = $values['orderBy'];

                    if (isset($values['orderByDirection']) && isset($directions[$values['orderByDirection']]) && $values['orderByDirection']) {
                        $mapfile[$field_name]['orderByDirection'] = $values['orderByDirection'];
                    } elseif (isset($mapfile[$field_name]['orderByDirection'])) {
                        unset($mapfile[$field_name]['orderByDirection']);
                    }

                } elseif (isset($mapfile[$field_name]['orderBy'])) {
                    unset($mapfile[$field_name]['orderBy']);
                    if (isset($mapfile[$field_name]['orderByDirection'])) {
                        unset($mapfile[$field_name]['orderByDirection']);
                    }
                }
            }

            $file->write($mapfile);

            return jipTools::closeWindow();
        }

        $defaults = new arrayDataspace();
        if ($isEdit) {
            $defaults->import($mapfile[$field_name]);
            $defaults->set('name', $field_name);
        } else {
            $defaults->set('mutator', 'set');
            $defaults->set('accessor', 'get');
        }

        if ($isEdit) {
            $url = new url('adminMap');
            $url->add('class', $class_name);
            $url->add('field', $field_name);
        } else {
            $url = new url('withAnyParam');
            $url->setSection('admin');
            $url->add('name', $class_name);
        }
        $url->setAction($action);

        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('directions', $directions);
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('defaults', $defaults);
        $this->smarty->assign('field_name', $field_name);
        $this->smarty->assign('form_action', $url->get());
        return $this->smarty->fetch('admin/savemap.tpl');
    }
}

function addMapNameValidate($name, $mapfile)
{
    return !isset($mapfile[$name]);
}

function addMapMethodValidate($name, $mapfile, $fieldname)
{
    foreach ($mapfile as $key => $val) {
        if (($val['accessor'] == $name || $val['mutator'] == $name) && $fieldname != $key) {
            return false;
        }
    }

    return true;
}

function notEqual($first, $second)
{
    return $first != $second;
}

?>