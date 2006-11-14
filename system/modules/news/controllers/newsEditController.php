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
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsMapper = $this->toolkit->getMapper('news', 'news', $this->request->getSection());

        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = $this->request->get('id', 'integer', SC_POST);
        }

        $news = $newsMapper->searchById($id);

        if ($news) {
            $form = newsEditForm::getForm($news, $this->request->getSection());

            if ($form->validate() == false) {
                $view = new newsEditView($news, $form);
            } else {
                $news->setTitle($this->request->get('title', 'string', SC_POST));
                $news->setEditor($user);
                $news->setText($this->request->get('text', 'string', SC_POST));
                $newsMapper->save($news);

                $view = new simpleJipRefreshView();
            }
            return $view;
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}

?>
