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
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $pageMapper = $this->toolkit->getMapper('page', 'page', $this->request->getSection());

        $name = $this->request->get('name', 'string', SC_PATH);
        $page = $pageMapper->searchByName($name);

        $action = $this->request->getAction();

        if (!empty($page) || $action == 'create') {
            $form = pageEditForm::getForm($page, $this->request->getSection(), $action, $pageMapper);

            if ($form->validate() == false) {
                $view = new pageEditView($page, $form, $action);
            } else {
                $values = $form->exportValues();
                if ($action == 'create') {
                    $page = $pageMapper->create();
                }
                $page->setName($values['name']);
                $page->setTitle($values['title']);
                $page->setContent($values['content']);
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
