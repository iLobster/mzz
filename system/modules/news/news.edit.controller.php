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
        fileLoader::load('news.edit.view');
        fileLoader::load('news.edit.success.view');
        fileLoader::load('news.edit.form');
        fileLoader::load('news.view.view');
        fileLoader::load("news");
        fileLoader::load("news/newsMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();

        $newsMapper = new newsMapper($httprequest->getSection());

        if(($id = $httprequest->get(0, SC_PATH)) == false) {
            $id = $httprequest->get('id', SC_POST);
        }
        $news = $newsMapper->searchById($id);

        $form = newsEditForm::getForm($news);

        if($form->validate() == false) {
            $view = new newsEditView($news, $form);
        } else {
            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setText($values['text']);
            $newsMapper->update($news);
            $view = new newsEditSuccessView($news, $form);
            header('Location: /news/' . $values['id'] . '/view'); // TODO: перенести этот редирект в newsEditSuccessView когда будет URL-генератор
        }
        return $view;
    }
}

?>
