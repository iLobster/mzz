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
 * @package modules
 * @subpackage news
 * @version 0.1
 */
 
fileLoader::load('news/views/newsEditView');
fileLoader::load('news/views/newsEditSuccessView');
fileLoader::load('news/views/newsEditForm');
fileLoader::load("news/mappers/newsMapper");
        
class newsEditController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsMapper = $this->toolkit->getMapper('news', 'news', $this->request->getSection());

        if (($id = $this->request->get(0, 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $news = $newsMapper->searchById($id);

        if ($news) {
            $form = newsEditForm::getForm($news, $this->request->getSection());

            if ($form->validate() == false) {
                $view = new newsEditView($news, $form);
            } else {
                $values = $form->exportValues();
                $news->setTitle($values['title']);
                $news->setEditor($user);
                $news->setText($values['text']);
                $newsMapper->save($news);

                //$newsMapper->setInvalid();

                $view = new newsEditSuccessView($news, $form);
            }
            return $view;
        } else {
            fileLoader::load('news/views/news.404.view');
            return new news404View();
        }
    }
}

?>
