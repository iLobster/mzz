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

fileLoader::load('news/views/newsCreateFolderForm');

/**
 * newsCreateController: контроллер для метода create модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1.2
 */

class newsCreateFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');

        $path = $this->request->get('name', 'string', SC_PATH);

        $targetFolder = $newsFolderMapper->searchByPath($path);

        $action = $this->request->getAction();

        if (!is_null($targetFolder)) {

            $form = newsCreateFolderForm::getForm($path, $newsFolderMapper, $action, $targetFolder);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('action', $action);

                $title = $action == 'edit' ? 'Редактирование папки -> ' . $targetFolder->getTitle() : 'Создание папки';
                $this->response->setTitle('Новости -> ' . $title);

                $view = $this->smarty->fetch('news/createFolder.tpl');
            } else {
                $values = $form->exportValues();

                if ($action == 'createFolder') {
                    // создаём папку
                    $folder = $newsFolderMapper->create();
                } else {
                    // изменяем папку
                    $folder = $newsFolderMapper->searchByPath($path);
                    $targetFolder = null;
                }

                $folder->setName($values['name']);
                $folder->setTitle($values['title']);

                $newsFolderMapper->save($folder, $targetFolder);

                $view = jipTools::redirect();
            }
        } else {
            $view = $this->get404()->getView();
        }

        return $view;
    }
}

?>