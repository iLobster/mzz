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
        //fileLoader::load('news.edit.model'); отцепляем?
        fileLoader::load('news.edit.view');
        fileLoader::load('news.edit.form');
        fileLoader::load("news/newsActiveRecord");
        fileLoader::load("news/newsTableModule");
        fileLoader::load("news.edit.success.view");
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $httprequest = $toolkit->getRequest();
        $params = $httprequest->getParams();

        $table_module = new newsTableModule($httprequest->getSection());

        $news = $table_module->searchById($params[0]);
        $form = newsEditForm::getForm($news);

        if($form->validate() == false) {
            $view = new newsEditView($news, $form);
        } else {
            $view = new newsEditSuccessView($news, $form);
        }
        return $view;
    }
}

?>