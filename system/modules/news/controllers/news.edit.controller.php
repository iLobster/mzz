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

class newsEditController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.edit.view');
        fileLoader::load('news/views/news.edit.success.view');
        fileLoader::load('news/views/news.edit.form');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
        parent::__construct();
    }

    public function getView()
    {
        $user = $this->toolkit->getUser();

        //$newsMapper = $this->toolkit->getCache(new newsMapper($this->request->getSection()));
        $newsMapper = new newsMapper($this->request->getSection());

        if (($id = $this->request->get(0, SC_PATH)) == false) {
            $id = $this->request->get('id', SC_POST);
        }
        $news = $newsMapper->searchById($id);

        $form = newsEditForm::getForm($news, $this->request->getSection());

        if ($form->validate() == false) {
            $view = new newsEditView($news, $form);
        } else {
            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setEditor($user->getLogin());
            $news->setText($values['text']);
            $newsMapper->save($news);

            $newsMapper->setInvalid();

            $view = new newsEditSuccessView($news, $form);
        }
        return $view;
    }
}

?>
