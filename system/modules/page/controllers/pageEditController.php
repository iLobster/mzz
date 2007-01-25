<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * pageEditController: контроллер для метода edit модуля page
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */

fileLoader::load('page/views/pageEditView');
fileLoader::load('page/views/pageEditForm');
fileLoader::load("page/mappers/pageMapper");

class pageEditController extends simpleController
{
    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page');

        $name = $this->request->get('name', 'string', SC_PATH);

        if (strpos($name, '/') !== false) {
            $folder = substr($name, 0, strrpos($name, '/'));
            $pagename = substr(strrchr($name, '/'), 1);
        } else {
            $pagename = $name;
        }

        $page = $pageMapper->searchByName($pagename);

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
                $view = new pageEditView($page, $form, $action);
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