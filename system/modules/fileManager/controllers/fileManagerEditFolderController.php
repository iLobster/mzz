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

fileLoader::load('fileManager/views/folderEditForm');

/**
 * fileManagerEditFolderController: контроллер для метода editFolder модуля fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.1
 */

class fileManagerEditFolderController extends simpleController
{
    public function getView()
    {
        $path = $this->request->get('name', 'string', SC_PATH);
        $action = $this->request->getAction();

        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $targetFolder = $folderMapper->searchByPath($path);

        if (!$targetFolder) {
            return 'каталог не найден';
        }

        $form = folderEditForm::getForm($targetFolder, $folderMapper, $action);

        if ($form->validate()) {
            $values = $form->exportValues();

            if ($action == 'editFolder') {
                $folder = $targetFolder;
                $targetFolder = null;
            } else {
                // создаём папку
                $folder = $folderMapper->create();
            }

            $folder->setName($values['name']);
            $folder->setTitle($values['title']);
            $folder->setExts($values['exts']);
            $folder->setFilesize($values['filesize']);

            $folderMapper->save($folder, $targetFolder);

            return jipTools::redirect();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('fileManager/editFolder.tpl');
    }
}

?>