<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2009
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * configSaveController: контроллер для метода edit модуля config
 *
 * @package modules
 * @subpackage config
 * @version 0.1
 */

class configSaveController extends simpleController
{
    protected function getView()
    {
        $action = $this->request->getAction();
        $isEdit = ($action == 'edit');

        $configOptionMapper = $this->toolkit->getMapper('config', 'configOption');
        $configFolderMapper = $this->toolkit->getMapper('config', 'configFolder');

        if ($isEdit) {
            $id = $this->request->getInteger('id');
            $option = $configOptionMapper->searchById($id);

            if (!$option) {
                return $this->forward404($configOptionMapper);
            }
            $folder = $configFolderMapper->searchByName($option->getModuleName());
        } else {
            $name = $this->request->getString('name');
            $folder = $configFolderMapper->searchByName($name);

            if (!$folder) {
                return $this->forward404($configFolderMapper);
            }

            $option = $configOptionMapper->create();
        }

        $types = $configOptionMapper->getTypes();

        $validator = new formValidator();
        $validator->add('required', 'name', 'Укажите имя для параметра');
        $validator->add('required', 'title', 'Укажите заголовок для параметра');
        $validator->add('required', 'type_id', 'Укажите тип параметра');
        $validator->add('in', 'type_id', 'Укажите тип параметра', array_keys($types));
        $validator->add('regex', 'name', 'Недопустимые символы в имени', '/^[a-z0-9_\.\-!]+$/i');
        $validator->add('callback', 'name', 'Такое имя уже есть в этом модуле', array('checkOptionName', $option, $folder, $configOptionMapper));

        if ($validator->validate()) {
            $name = $this->request->getString('name', SC_POST);
            $title = $this->request->getString('title', SC_POST);
            $type_id = $this->request->getInteger('type_id', SC_POST);

            $option->setName($name);
            $option->setTitle($title);
            $option->setType($type_id);

            if (!$isEdit) {
                $option->setModuleName($folder->getName());
            }

            $configOptionMapper->save($option);
            return jipTools::closeWindow();
        }

        if ($isEdit) {
            $url = new url('withId');
            $url->setAction('edit');
            $url->add('id', $id);
        } else {
            $url = new url('withAnyParam');
            $url->setAction('add');
            $url->add('name', $name);
        }

        $this->smarty->assign('types', $types);
        $this->smarty->assign('form_action', $url->get());
        $this->smarty->assign('isEdit', $isEdit);
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('option', $option);
        $this->smarty->assign('folder', $folder);
        return $this->smarty->fetch('config/save.tpl');
    }
}

function checkOptionName($name, $option, $folder, $optionMapper)
{
    if ($name == $option->getName()) {
        return true;
    }

    $criteria = new criteria();
    $criteria->add('module_name', $folder->getName())->add('name', $name);
    return is_null($optionMapper->searchOneByCriteria($criteria));
}

?>