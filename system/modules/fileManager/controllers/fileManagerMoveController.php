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
 * fileManagerMoveController: контроллер дл€ метода move модул€ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerMoveController extends simpleController
{
    public function getView()
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
        $validator->add('callback', 'dest', '¬ каталоге назначени€ уже есть файл с таким же именем', array('checkFilename', $file));

        if ($validator->validate()) {
            $destFolder = $folderMapper->searchById($dest);

            if (!$destFolder) {
                return $folderMapper->get404()->run();
            }

            $file->setFolder($destFolder);
            $fileMapper->save($file);
            return jipTools::redirect();
        }


        $url = new url('withAnyParam');
        $url->setAction('move');
        $url->addParam('name', $file->getFullPath());
        $this->smarty->assign('form_action', $url->get());

        $dests = array();
        foreach ($folders as $val) {
            $dests[$val->getId()] = $val->getPath();
        }
        $this->smarty->assign('dests', $dests);

        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('file', $file);
        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('fileManager/move.tpl');
    }
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