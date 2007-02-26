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

fileLoader::load('page/views/pageCreateFolderForm');

/**
 * pageCreateFolderController: контроллер для метода createFolder модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class pageCreateFolderController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');

        $path = $this->request->get('name', 'string', SC_PATH);

        $targetFolder = $pageFolderMapper->searchByPath($path);

        $action = $this->request->getAction();

        if (!is_null($targetFolder)) {

            $form = pageCreateFolderForm::getForm($path, $pageFolderMapper, $action, $targetFolder);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());

                $this->smarty->assign('action', $action);
                $this->response->setTitle('Страницы -> Создание папки');
                $view = $this->smarty->fetch('page/createFolder.tpl');
            } else {
                $values = $form->exportValues();

                if ($action == 'createFolder') {
                    // создаём папку
                    $folder = $pageFolderMapper->create();
                } else {
                    // изменяем папку
                    $folder = $pageFolderMapper->searchByPath($path);
                    $targetFolder = null;
                }

                $folder->setName($values['name']);
                $folder->setTitle($values['title']);

                $pageFolderMapper->save($folder, $targetFolder);

                $view = jipTools::redirect();
            }
        } else {
            //fileLoader::load('page/views/page404View');
            //$view = new page404View();
        }

        return $view;
    }
}

?>