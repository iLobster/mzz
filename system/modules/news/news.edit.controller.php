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

class newsEditController
{
    public function __construct()
    {
        fileLoader::load('news.edit.model');
        fileLoader::load('news.edit.view');
        fileLoader::load("news/newsActiveRecord");
        fileLoader::load("news/newsTableModule");
    }

    public function getView()
    {
        $registry = Registry::instance();
        $this->httprequest = $registry->getEntry('httprequest');
        $params = $this->httprequest->getParams();
        // тут будет как нибудь похитрее - но пока не надо
        return new newsEditView(new newsTableModule(), $params);
    }
}

?>