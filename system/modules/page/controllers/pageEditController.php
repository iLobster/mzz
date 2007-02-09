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

fileLoader::load('page/views/pageEditForm');

/**
 * pageEditController: контроллер для метода edit модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

class pageEditController extends simpleController
{
    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $name = $this->request->get('name', 'string', SC_PATH);

        $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
        $page = $pageFolderMapper->searchChild($name);

        $action = $this->request->getAction();

        if ($action == 'create') {
            $pageFolderMapper = $this->toolkit->getMapper('page', 'pageFolder');
            $pageFolder = $pageFolderMapper->searchByPath($name);
        } else {
            $pageFolder = $page->getFolder();
        }

        if (!empty($page) || $action == 'create') {
            $form = pageEditForm::getForm($page, $this->request->getSection(), $action, $pageFolder);

            if ($form->validate() == false) {
                $renderer = new HTML_QuickForm_Renderer_ArraySmarty($this->smarty, true);
                $form->accept($renderer);

                $this->smarty->assign('form', $renderer->toArray());
                $this->smarty->assign('page', $page);
                $this->smarty->assign('action', $action);

                $title = $action == 'edit' ? 'Редактирование -> ' . $page->getName() : 'Создание';
                $this->response->setTitle('Страницы -> ' . $title);
                $view = $this->smarty->fetch('page/edit.tpl');
            } else {
                $values = $form->exportValues();
                if ($action == 'create') {
                    $page = $pageMapper->create();
                }
                $page->setName($values['name']);
                $page->setTitle($values['title']);
                $page->setContent($values['contentArea']);
                $page->setFolder($pageFolder);
                $pageMapper->save($page);
                $view = new simpleJipRefreshView();
            }
            return $view;
        } else {
            fileLoader::load('page/views/page404View');
            return new page404View();
        }
    }
}

?>