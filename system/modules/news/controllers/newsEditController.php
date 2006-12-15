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
fileLoader::load('news/views/newsEditForm');
fileLoader::load("news/mappers/newsMapper");

class newsEditController extends simpleController
{
    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsMapper = $this->toolkit->getMapper('news', 'news', $this->request->getSection());

        $id = $this->request->get('id', 'integer', SC_PATH);

        $newsFolder = null;

        if (is_null($id)) {
            $path = $this->request->get('name', 'string', SC_PATH);
            $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder');
            $newsFolder = $newsFolderMapper->searchByPath($path);
        }

        $news = $newsMapper->searchById($id);

        $action = $this->request->getAction();
        if (!empty($news) || ($action == 'createItem' && isset($newsFolder) && !is_null($newsFolder))) {
            $form = newsEditForm::getForm($news, $this->request->getSection(), $action, $newsFolder);

            if ($form->validate() == false) {
                $view = new newsEditView($news, $form, $action);
            } else {
                $values = $form->exportValues();
                $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());
                $folder = $newsFolderMapper->searchByPath($this->request->get('name', 'string', SC_PATH));

                if ($action == 'createItem') {
                    $news = $newsMapper->create();
                    $news->setFolder($folder->getId());
                }

                $news->setTitle($values['title']);
                $news->setEditor($user);
                $news->setText($values['text']);
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
