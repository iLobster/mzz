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

fileLoader::load('page/forms/pageSaveFolderForm');

/**
 * pageSaveFolderController: контроллер для метода saveFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageSaveFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();
        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $path = $this->request->get('name', 'string', SC_PATH);
        $targetFolder = $pageFolderMapper->searchByPath($path);

        $action = $this->request->getAction();
        $isEdit = ($action == 'editFolder');

        if (!is_null($targetFolder)) {

            $form = pageSaveFolderForm::getForm($path, $pageFolderMapper, $action, $targetFolder, $isEdit);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('isEdit', $isEdit);

                $title = $isEdit ? 'Редактирование папки -> ' . $targetFolder->getName() : 'Создание папки';
                $this->response->setTitle('Страницы -> ' . $title);
                $view = $this->smarty->fetch('page/saveFolder.tpl');
            } else {
                $values = $form->exportValues();

                if ($isEdit) {
                    // изменяем папку
                    $folder = $pageFolderMapper->searchByPath($path);
                    $targetFolder = null;
                } else {
                    // создаём папку
                    $folder = $pageFolderMapper->create();
                }

                $folder->setName($values['name']);
                $folder->setTitle($values['title']);

                $pageFolderMapper->save($folder, $targetFolder);

                $view = jipTools::redirect();
            }
        } else {
            return $pageFolderMapper->get404()->run();
        }

        return $view;
    }
}

?>