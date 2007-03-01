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

fileLoader::load('news/views/newsSaveFolderForm');

/**
 * newsSaveController: контроллер для метода save модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsSaveFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();
        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $targetFolder = $newsFolderMapper->searchByPath($path);
        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        if (empty($targetFolder)) {
            return $newsFolderMapper->get404()->run();
        }

        $form = newsSaveFolderForm::getForm($path, $newsFolderMapper, $action, $targetFolder, $isEdit);
        if ($form->validate() == false) {
            $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
            $form->accept($renderer);

            $this->smarty->assign('form', $renderer->toArray());
            $this->smarty->assign('isEdit', $isEdit);

            $title = $isEdit ? 'Редактирование папки -> ' . $targetFolder->getTitle() : 'Создание папки';
            $this->response->setTitle('Новости -> ' . $title);

            return $this->smarty->fetch('news/saveFolder.tpl');
        } else {
            $values = $form->exportValues();

            if ($isEdit) {
                // изменяем папку
                $folder = $newsFolderMapper->searchByPath($path);
                $targetFolder = null;
            } else {
                // создаём папку
                $folder = $newsFolderMapper->create();
            }

            $folder->setName($values['name']);
            $folder->setTitle($values['title']);

            $newsFolderMapper->save($folder, $targetFolder);

            return jipTools::redirect();
        }
    }
}

?>