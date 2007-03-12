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
 * catalogueMoveFolderController: контроллер для метода moveFolder модуля catalogue
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
            return 'Невозможно перемещать данный каталог';
        }

        $form = catalogueFolderMoveForm::getForm($folder, $folders);

        if ($form->validate()) {
            $values = $form->exportValues();

            if (isset($values['dest'])) {
                $destFolder = $catalogueFolderMapper->searchByParentId($values['dest']);

                if (!$destFolder) {
                    return 'каталог назначения не найден';
                }

                if (!isset($folders[$values['dest']])) {
                    return 'Нельзя перенести каталог во вложенные каталоги';
                }

                $duplicate = $catalogueFolderMapper->searchByPath($destFolder->getPath() . '/' . $folder->getName());
                if (!$duplicate) {
                    $result = $catalogueFolderMapper->move($folder, $destFolder);

                    if ($result) {
                        return jipTools::redirect();
                    }

                    $form->setElementError('dest', 'Невозможно осуществить данное перемещение');

                } else {
                    $form->setElementError('dest', 'В выбранном каталоге назначения уже существует каталог с таким именем');
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