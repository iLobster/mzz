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
 * @version 0.1
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
                // ищем все каталоги, которые лежат ниже изменяемого
                $criteria = new criteria();
                $criteria->add('path', $path . '/%', criteria::LIKE);
                $folders = $folderMapper->searchAllByCriteria($criteria);

                $pos = strrpos('/' . $path, '/');
                if ($pos) {
                    $path = substr($path, 0, $pos - 1) . '/';
                } else {
                    $path = '';
                }

                // для нижележащих каталогов меняем значение поля `path` на новое
                foreach ($folders as $currentFolder) {
                    $currentFolder->setPath(str_replace($folder->getPath(), $path . $values['name'], $currentFolder->getPath()));
                    $folderMapper->save($currentFolder);
                }
            } else {
                // создаём папку
                $folder = $folderMapper->create();

                $folderMapper->createSubfolder($folder, $targetFolder);

                $path .= '/';
            }

            $folder->setName($values['name']);
            $folder->setTitle($values['title']);
            $folder->setPath($path . $values['name']);

            $folderMapper->save($folder);

            return new simpleJipRefreshView();
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('action', $action);
        $this->smarty->assign('form', $renderer->toArray());

        return $this->smarty->fetch('fileManager/editFolder.tpl');
    }
}

?>