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
 * @package modules
 * @subpackage news
 * @version 0.1
 */

/*fileLoader::load('news/views/newsCreateView');
fileLoader::load('news/views/newsCreateSuccessView');
fileLoader::load('news/views/newsCreateForm');
fileLoader::load("news/mappers/newsMapper");
fileLoader::load("news/mappers/newsFolderMapper");*/

fileLoader::load('news/views/newsCreateFolderForm');
fileLoader::load('news/views/newsCreateFolderView');

class newsCreateFolderController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $user = $this->toolkit->getUser();

        $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());
        $newsFolder = $newsFolderMapper->create();

        $form = newsCreateFolderForm::getForm($this->request->get('name', 'string', SC_PATH));

        if ($form->validate() == false) {
            $view = new newsCreateFolderView($newsFolder, $form);
        } else {
            $newsFolderMapper = $this->toolkit->getMapper('news', 'newsFolder', $this->request->getSection());
            $folder = $newsFolderMapper->searchByName($this->request->get('name', 'string', SC_PATH));
            var_dump($folder);
/*
            $values = $form->exportValues();
            $news->setTitle($values['title']);
            $news->setEditor($user->getId());
            $news->setText($values['text']);
            $news->setFolder($folder->getId());
            $newsMapper->save($news);

            $acl = new acl($user, (int)$news->getObjId(), $newsMapper->name(), $this->request->getSection());
            $acl->register((int)$news->getObjId(), $newsMapper->name(), $this->request->getSection());

            $view = new newsCreateSuccessView($news, $form);*/
        }

        return $view;
    }
}

?>