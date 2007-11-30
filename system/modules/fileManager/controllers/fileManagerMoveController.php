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
 * fileManagerMoveController: контроллер для метода move модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerMoveController extends simpleController
{
    protected function getView()
    {
        $name = $this->request->get('name', 'string', SC_PATH);
        $dest = $this->request->get('dest', 'integer', SC_POST);

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return $fileMapper->get404()->run();
        }

        $folders = $folderMapper->searchAll();

        $validator = new formValidator();
        $validator->add('required', 'dest', 'Обязательное для заполнения поле');
        $validator->add('callback', 'dest', 'В каталоге назначения уже есть файл с таким же именем', array('checkFilename', $file));
        $validator->add('callback', 'dest', 'Каталог назначения не существует', array('checkDestFMFolderExists', $folderMapper));

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);

            $file->setFolder($destFolder);
            $fileMapper->save($file);
            return jipTools::redirect();
        }


        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->add('name', $file->getFullPath());
        $this->smarty->assign('form_action', $url->get());

        $dests = array();
        $styles = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getTitle();
            $styles[$val->getId()] = 'padding-left: ' . ($val->getTreeLevel() * 15) . 'px;';
        }

        $this->smarty->assign('dests', $dests);
        $this->smarty->assign('styles', $styles);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('file', $file);
        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('fileManager/move.tpl');
    }
}

function checkDestFMFolderExists($id, $folderMapper)
{
    $destFolder = $folderMapper->searchById($id);
    return !empty($destFolder);
}

function checkFilename($dest, $file)
{
    $folderMapper = systemToolkit::getInstance()->getMapper('fileManager', 'folder');
    $fileMapper = systemToolkit::getInstance()->getMapper('fileManager', 'file');

    $destFolder = $folderMapper->searchById($dest);

    if (!$destFolder) {
        return false;
    }

    $criteria = new criteria();
    $criteria->add('folder_id', $destFolder->getId())->add('name', $file->getName());

    return is_null($fileMapper->searchOneByCriteria($criteria));
}

?>