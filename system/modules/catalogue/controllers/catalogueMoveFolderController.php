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

fileLoader::load('catalogue/forms/catalogueFolderMoveForm');
 
/**
 * catalogueMoveFolderController: ���������� ��� ������ moveFolder ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueMoveFolderController extends simpleController
{
    public function getView()
    {
        $catalogueFolderMapper = $this->toolkit->getMapper('catalogue', 'catalogueFolder');
        $path = $this->request->get('name', 'string', SC_PATH);

        $folder = $catalogueFolderMapper->searchByPath($path);
        if (!$folder) {
            return $catalogueFolderMapper->get404()->run();
        }

        $folders = $catalogueFolderMapper->getTreeExceptNode($folder);

        if (sizeof($folders) <= 1) {
            return '���������� ���������� ������ �������';
        }

        $form = catalogueFolderMoveForm::getForm($folder, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            if (isset($values['dest'])) {
                $destFolder = $catalogueFolderMapper->searchByParentId($values['dest']);

                if (!$destFolder) {
                    return '������� ���������� �� ������';
                }

                if (!isset($folders[$values['dest']])) {
                    return '������ ��������� ������� �� ��������� ��������';
                }

                $duplicate = $catalogueFolderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
                if (!$duplicate) {
                    $result = $catalogueFolderMapper->move($folder, $destFolder);

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
        return $this->smarty->fetch('catalogue/moveFolder.tpl');
    }
}

?>