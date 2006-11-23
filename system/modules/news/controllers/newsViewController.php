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
 * NewsViewController: контроллер дл€ метода list модул€ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('news/views/newsViewView');
fileLoader::load("news/mappers/newsMapper");

class newsViewController extends simpleController
{
    public function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news', $this->request->getSection());

         //√енерилка "мусора" ;)
        /*for ($i=0; $i<=10000; $i++) {
            $news = $newsMapper->create();
            $news->setText(md5(microtime()));
            $news->setTitle(md5(microtime()));
            $news->setFolder(2);
            $newsMapper->save($news);
        }*/

        if (($id = $this->request->get('id', 'integer', SC_PATH)) == null) {
            $id = 0;
        }
        $news = $newsMapper->searchById($id);

        if ($news) {
            return new newsViewView($news);
        } else {
            fileLoader::load('news/views/news404View');
            return new news404View();
        }
    }
}

?>