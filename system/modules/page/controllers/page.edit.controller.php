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
 * @package page
 * @version 0.1
 */

class pageEditController
{
    public function __construct()
    {
        fileLoader::load('page/views/page.edit.view');
        fileLoader::load('page/views/page.edit.success.view');
        fileLoader::load('page/views/page.edit.form');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $pageMapper = new pageMapper($httprequest->getSection());

        if (($name = $httprequest->get(0, SC_PATH)) == false) {
            $name = $httprequest->get('name', SC_POST);
        }
        $page = $pageMapper->searchByName($name);

        $form = pageEditForm::getForm($page, $httprequest->getSection());

        if ($form->validate() == false) {
            $view = new pageEditView($page, $form);
        } else {
            $values = $form->exportValues();
            $page->setName($values['name']);
            $page->setTitle($values['title']);
            $page->setContent($values['content']);
            $pageMapper->save($page);
            $view = new pageEditSuccessView($page, $form);
        }
        return $view;
    }
}

?>
