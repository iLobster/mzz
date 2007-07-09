<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
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
 * catalogueSaveFolderController: контроллер для метода saveFolder модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveFolderController extends simpleController
{
    protected function getView()
    {
        $user = $this->toolkit->getUser();
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $targetFolder = $catalogueFolderMapper->searchByPath($path);

        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        if (empty($targetFolder)) {
            return $catalogueFolderMapper->get404()->run();
        }

        if ($isEdit) {
            $folder = $catalogueFolderMapper->searchByPath($path);
            $targetFolder = null;
        } else {
            $folder = $catalogueFolderMapper->create();
        }

        $validator = new formValidator();
        $validator->add('required', 'name', 'Необходимо назвать папку');
        $validator->add('regex', 'name', 'Только алфавитно-цифровые символы', '/[^\W\d][\w\d_]*/');
        $validator->add('callback', 'name', 'Уникальное имя в пределах каталога', array('checkCatalogueFolderName', $path, $catalogueFolderMapper, $isEdit));

        if ($validator->validate()) {
            $name = $this->request->get('name', 'string', SC_POST);
            $title = $this->request->get('title', 'string', SC_POST);
            $defaultType = $this->request->get('defaultType', 'integer', SC_POST);

            $folder->setName($name);
            $folder->setTitle($title);
            $folder->setDefType($defaultType);

            $catalogueFolderMapper->save($folder, $targetFolder);

            return jipTools::redirect();
        }

        $url = new url('withAnyParam');
        $url->setSection($this->request->getSection());
        $url->setAction($action);
        $url->addParam('name', $isEdit ? $folder->getPath() : $targetFolder->getPath());

        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $types_tmp = $catalogueMapper->getAlltypes();
        $types = array('' => '');
        foreach ($types_tmp as $type) {
            $types[$type['id']] = $type['title'];
        }

        $this->smarty->assign('types', $types);

        $folder = $isEdit ? $folder : $catalogueFolderMapper->create();
        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('isEdit', $isEdit);
        return $this->smarty->fetch('catalogue/saveFolder.tpl');

    }
}


function checkCatalogueFolderName($name, $path, $mapper, $isEdit)
{
    if ($isEdit) {
        $path = explode('/', $path);
        $current = array_pop($path);

        return $current == $name || is_null($mapper->searchByPath(implode('/', $path) . '/' . $name));
    } else {
        return is_null($mapper->searchByPath($path . '/' . $name));
    }
}
?>