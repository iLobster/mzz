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

fileLoader::load('fileManager/forms/fileMoveForm');

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

        $fileMapper = $this->toolkit->getMapper('fileManager', 'file');
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $file = $fileMapper->searchByPath($name);

        if (!$file) {
            return 'файл не найден';
        }

        $folders = $folderMapper->searchAll();

        $form = fileMoveForm::getForm($file, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            $destFolder = $folderMapper->searchById($values['dest']);

            if (!$destFolder) {
                return 'каталог назначени€ не найден';
            }

            $criteria = new criteria();
            $criteria->add('folder_id', $destFolder->getId())->add('name', $file->getName());
            $duplicate = $fileMapper->searchOneByCriteria($criteria);

            if (!$duplicate) {
                $file->setFolder($destFolder);
                $fileMapper->save($file);
                return jipTools::redirect();
            }

            $form->setElementError('dest', '¬ каталоге назначени€ уже есть файл с таким же именем');
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('file', $file);
        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('fileManager/move.tpl');
    }
}

?>