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
 * newsCreateController: ���������� ��� ������ create ������ news
 *
 * @package news
 * @version 0.1
 */

class newsCreateController extends simpleController
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
        parent::__construct();
    }

    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsMapper = new newsMapper($this->request->getSection());
        $news = $newsMapper->create();


        $form = newsCreateForm::getForm($this->request->get(0, SC_PATH));
        if ($form->validate() == false) {
            $view = new newsCreateView($news, $form);
        } else {
            $newsFolder = new newsFolderMapper($this->request->getSection());
            $folder = $newsFolder->searchByName($this->request->get(0, SC_PATH));

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
