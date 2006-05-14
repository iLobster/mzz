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
 * pageCreateController: контроллер для метода create модуля page
 *
 * @package page
 * @version 0.1
 */

class pageCreateController
{
    public function __construct()
    {
        fileLoader::load('page/views/page.create.view');
        fileLoader::load('page/views/page.create.success.view');
        fileLoader::load('page/views/page.create.form');
        fileLoader::load("page");
        fileLoader::load("page/mappers/pageMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $pageMapper = new pageMapper($httprequest->getSection());
        $page = $pageMapper->create();


        $form = pageCreateForm::getForm();
        if ($form->validate() == false) {
            $view = new pageCreateView($page, $form);
        } else {
            $values = $form->exportValues();
            $page->setName($values['name']);
            $page->setTitle($values['title']);
            $page->setContent($values['content']);
            $pageMapper->save($page);
            $view = new pageCreateSuccessView($page, $form);
        }
        return $view;
    }
}

?>
