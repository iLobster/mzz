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

fileLoader::load('fileManager/views/folderMoveForm');

/**
 * fileManagerMoveFolderController: ���������� ��� ������ moveFolder ������ fileManager
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1
 */

class fileManagerMoveFolderController extends simpleController
{
    public function getView()
    {
        $folderMapper = $this->toolkit->getMapper('fileManager', 'folder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $folderMapper->searchByPath($path);
        if (!$folder) {
            return '������� �� ������';
        }

        $folders = $folderMapper->getTreeExceptNode($folder);

        if (!sizeof($folders)) {
            return '���������� ���������� ������ �������';
        }

        $form = folderMoveForm::getForm($folder, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            if (isset($values['dest'])) {
                $destFolder = $folderMapper->searchById($values['dest']);
                if (!$destFolder) {
                    return '������� ���������� �� ������';
                }

                if (!isset($folders[$values['dest']])) {
                    return '������ ��������� ������� �� ��������� ��������';
                }

                $duplicate = $folderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
                if (!$duplicate) {
                    $result = $folderMapper->move($folder, $destFolder);

                    if ($result) {
                        return jipTools::redirect();
                    }

                    $form->setElementError('dest', '���������� ����������� ������ �����������');

                } else {
                    $form->setElementError('dest', '� ��������� �������� ���������� ��� ���������� ������� � ����� ������');
                }
            }
        }

        $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
        $form->accept($renderer);

        $this->smarty->assign('form', $renderer->toArray());
        $this->smarty->assign('folder', $folder);
        $this->smarty->assign('folders', $folders);
        return $this->smarty->fetch('fileManager/moveFolder.tpl');
    }
}

?>