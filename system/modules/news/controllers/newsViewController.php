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
 * @package modules
 * @subpackage news
 * @version 0.1
 */

fileLoader::load('news/views/newsViewView');
fileLoader::load("news/mappers/newsMapper");

class newsViewController extends simpleController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news', $this->request->getSection());
        //$newsMapper = new newsMapper($this->request->getSection());

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