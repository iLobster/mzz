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

class newsEditController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.edit.view');
        fileLoader::load('news/views/news.edit.success.view');
        fileLoader::load('news/views/news.edit.form');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $user = $toolkit->getUser();

        $newsMapper = new newsMapper($httprequest->getSection());

        if (($id = $httprequest->get(0, SC_PATH)) == false) {
            $id = $httprequest->get('id', SC_POST);
        }
        $news = $newsMapper->searchById($id);

        $form = newsEditForm::getForm($news, $httprequest->getSection());

        if ($form->validate() == false) {
            $view = new newsEditView($news, $form);
        } else {
            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setEditor($user->getLogin());
            $news->setText($values['text']);
            $newsMapper->save($news);
            $view = new newsEditSuccessView($news, $form);
        }
        return $view;
    }
}

?>
