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

fileLoader::load('catalogue/forms/catalogueSaveFolderForm');

/**
 * catalogueSaveFolderController: контроллер для метода saveFolder модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueSaveFolderController extends simpleController
{
    public function getView()
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

        $form = catalogueSaveFolderForm::getForm($path, $catalogueFolderMapper, $action, $targetFolder, $isEdit);
        if ($form->validate() == false) {
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $renderer->setRequiredTemplate('{if $error}<font color="red"><strong>{$label}</strong></font>{else}{if $required}<span style="color: red;">*</span> {/if}{$label}{/if}');
            $renderer->setErrorTemplate('{if $error}<div class="formErrorElement">{$html}</div><font color="gray" size="1">{$error}</font>{else}{$html}{/if}');

            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('isEdit', $isEdit);

            $title = $isEdit ? 'Редактирование папки -> ' . $targetFolder->getTitle() : 'Создание папки';

            return $this->smarty->fetch('catalogue/saveFolder.tpl');
        } else {
            $values = $form->exportValues();

            if ($isEdit) {
                // изменяем папку
                $folder = $catalogueFolderMapper->searchByPath($path);
                $targetFolder = null;
            } else {
                // создаём папку
                $folder = $catalogueFolderMapper->create();
            }

            $folder->setName($values['name']);
            $folder->setTitle($values['title']);

            $catalogueFolderMapper->save($folder, $targetFolder);

            return jipTools::redirect();
        }
    }
}

?>