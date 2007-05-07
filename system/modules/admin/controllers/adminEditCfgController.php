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

/**
 * adminSaveCfgController: контроллер для метода SaveCfg модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1.1
 */

class adminSaveCfgController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer', SC_PATH);
        $name = $this->request->get('name', 'string', SC_PATH);
        $action = $this->request->getAction();
        $isEdit = ($action == 'editCfg');

        $db = DB::factory();

        $module = $db->getRow($qry = 'SELECT * FROM `sys_modules` WHERE `id` = ' . $id);
        $config = new config('', $module['name']);
        $params = $config->getDefaultValues();

        if ($isEdit && !isset($params[$name])) {
            $controller = new messageController('Выбранного параметра в конфигурации не существует', messageController::WARNING);
            return $controller->run();
        }

        $configInfo = array();
        $configInfo['name'] = $name;
        $configInfo['value'] = $isEdit ? $params[$name] : '';
        $configInfo['title'] = $config->getTitle($name);

        $validator = new formValidator();

        $validator->add('required', 'param', 'Необходимо указать имя параметра');
        $validator->add('regex', 'param', 'Недопустимые символы в имени параметра', '/^[a-z0-9_\-]+$/i');

        if ($validator->validate()) {
            /*$values = $form->exportValues();

            if ($isEdit) {
                $config->update($name, $values['param'], $values['value'], $values['title']);
            } else {
                $config->create($values['param'], $values['value'], $values['title']);
            }

            return jipTools::closeWindow();*/
        }



        if ($isEdit) {
            $url = new url('adminCfgEdit');
            $url->addParam('name', $name);
        } else {
            $url = new url('withId');
            $url->setSection('admin');
        }
        $url->setAction($action);
        $url->addParam('id', $module);

        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());

        $this->smarty->assign('configInfo', $configInfo);
        $this->smarty->assign('isEdit', $isEdit);

        return $this->smarty->fetch('admin/saveCfg.tpl');
    }
}



/*
        if (!empty($news) || (!$isEdit && isset($newsFolder) && !is_null($newsFolder))) {
            $validator = new formValidator();
            $validator->add('required', 'title', 'Необходимо назвать новость');

            if (!$isEdit) {
                $validator->add('required', 'created', 'Необходимо указать дату');
                $validator->add('regex', 'created', 'Правильный формат даты: чч:м:с д/м/г ', '#^([01][0-9]|[2][0-3]):([0-5][0-9]):([0-5][0-9])\s(0[1-9]|[12][0-9]|3[01])/(0[1-9]|1[012])[/](19|20)\d{2}$#');
            }


            if ($validator->validate()) {
                $title = $this->request->get('title', 'string', SC_POST);
                $annotation = $this->request->get('annotation', 'string', SC_POST);
                $text = $this->request->get('text', 'string', SC_POST);

                $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
                $folder = $newsFolderMapper->searchByPath($this->request->get('name', 'string', SC_PAT

                $news->setTitle($title);
                $news->setEditor($user);
                $news->setText($text);
                $news->setAnnotation($annotation);
                $newsMapper->save($news);

                return jipTools::redirect();
            }

            $url = new url('withAnyParam');
            $url->setSection($this->request->getSection());
            $url->setAction($action);
            $url->addParam('name', $isEdit ? $news->getId() : $newsFolder->getPath());
            $this->smarty->assign('action', $url->get());
            $this->smarty->assign('errors', $validator->getErrors());

            $this->smarty->assign('news', $news);
            $this->smarty->assign('isEdit', $isEdit);

            $title = $isEdit ? 'Редактирование -> ' . $news->getTitle() : 'Создание';
            $this->response->setTitle('Новости -> ' . $title);

            return $this->smarty->fetch('news/save.tpl');
        }

        return $newsMapper->get404()->run();
    }
}
*/
?>