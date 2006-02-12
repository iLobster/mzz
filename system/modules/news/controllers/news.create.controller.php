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
 * NewsEditController: контроллер для метода edit модуля news
 *
 * @package news
 * @version 0.1
 */

class newsCreateController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.create.view');
        fileLoader::load('news/views/news.create.success.view');
        fileLoader::load('news/views/news.create.form');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsMapper = new newsMapper($httprequest->getSection());


        $form = newsCreateForm::getForm($news);

        if($form->validate() == false) {
            $view = new newsEditView($news, $form);
        } else {
            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setText($values['text']);
            $newsMapper->update($news);
            $view = new newsEditSuccessView($news, $form);
        }
        return $view;
    }
}

?>
