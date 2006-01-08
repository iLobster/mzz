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
        fileLoader::load("news.success.edit.view");
    }

    public function getView()
    {
        $registry = Registry::instance();
        $this->httprequest = $registry->getEntry('httprequest');
        $params = $this->httprequest->getParams();
        $table_module = new newsTableModule();
        $form = newsEditForm::getForm($table_module, $params);
        if($form->validate() == false) {
            $view = new newsEditView($table_module, $form, $params);
        } else {
            $view = new newsSuccessEditView($table_module, $form);
        }
        // тут будет как нибудь похитрее - но пока не надо
        return $view;
    }
}

?>