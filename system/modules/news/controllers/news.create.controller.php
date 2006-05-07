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
 * newsCreateController: контроллер для метода create модуля news
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
        fileLoader::load("news/newsFolder");
        fileLoader::load("news/mappers/newsMapper");
        fileLoader::load("news/mappers/newsFolderMapper");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $user = $toolkit->getUser();

        $newsMapper = new newsMapper($httprequest->getSection());
        $news = $newsMapper->create();


        $form = newsCreateForm::getForm($httprequest->get(0, SC_PATH));
        if ($form->validate() == false) {
            $view = new newsCreateView($news, $form);
        } else {
            $newsFolder = new newsFolderMapper($httprequest->getSection());
            $folder = $newsFolder->searchByName($httprequest->get(0, SC_PATH));

            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setEditor($user->getLogin());
            $news->setText($values['text']);
            $news->setFolderId($folder->getId());
            $newsMapper->save($news);
            $view = new newsCreateSuccessView($news, $form);
        }
        return $view;
    }
}

?>
