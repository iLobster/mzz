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
 * NewsViewController: контроллер для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsViewController extends simpleController
{
    public function __construct()
    {
        fileLoader::load('news/views/news.view.view');
        fileLoader::load("news");
        fileLoader::load("news/mappers/newsMapper");
        parent::__construct();
    }

    public function getView()
    {
        $newsMapper = new newsMapper($this->request->getSection());

        if (($id = $this->request->get(0, SC_PATH)) == false) {
            $id = 0;
        }
        $news = $newsMapper->searchById($id);

        if ($news) {
            return new newsViewView($news);
        } else {
            fileLoader::load('news/views/news.404.view');
            return new news404View();
        }
    }
}

?>
