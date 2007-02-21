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

fileLoader::load('news/views/newsFolderMoveForm');

/**
 * newsMoveFolderController: ���������� ��� ������ moveFolder ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class newsMoveFolderController extends simpleController
{
    public function getView()
    {
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $newsFolderMapper->searchByPath($path);
        if (!$folder) {
            return '������� �� ������';
        }

        $folders = $newsFolderMapper->getTreeExceptNode($folder);

        if (sizeof($folders) <= 1) {
            return '���������� ���������� ������ �������';
        }

        $form = newsFolderMoveForm::getForm($folder, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            if (isset($values['dest'])) {
                $destFolder = $newsFolderMapper->searchByParentId($values['dest']);

                if (!$destFolder) {
                    return '������� ���������� �� ������';
                }

                if (!isset($folders[$values['dest']])) {
                    return '������ ��������� ������� �� ��������� ��������';
                }

                $duplicate = $newsFolderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
                if (!$duplicate) {
                    $result = $newsFolderMapper->move($folder, $destFolder);

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
        return $this->smarty->fetch('news/moveFolder.tpl');
    }
}

?>