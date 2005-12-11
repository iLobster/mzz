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
 * NewsListModel: модель для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsEditModel
{
    public function __construct()
    {

    }

    public function getNews()
    {
        $registry = Registry::instance();
        $httprequest = $registry->getEntry('httprequest');
        $params = $httprequest->getParams();
        $query = "SELECT * FROM `news` WHERE `id`=".($params[0]);
        $db = Db::factory();
        $news = array();
        if ($result = $db->query($query)) {
            $news = $result->fetch_assoc();
        }
        return $news;
    }

    public function getForm($data) {

        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('form', 'POST');
        $defaultValues = array();
        $defaultValues['name']  = $data['title'];
        $defaultValues['body']  = $data['text'];
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'name', 'Имя:', 'size=30');
        $form->addElement('textarea', 'body', 'Текст:', 'rows=7 cols=50');
        $form->addElement('hidden', 'path', '/news/save/');
        $form->addElement('hidden', 'news_id', $data['id']);
        $form->addElement('reset', 'reset', 'Сброс');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }


}

?>