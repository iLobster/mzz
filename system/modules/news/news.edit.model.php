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
 * NewsEditModel: модель для метода edit модуля news
 *
 * @package news
 * @version 0.1
 */

class newsEditModel
{
    private $httprequest;
    private $params;
    private $db;


    public function __construct()
    {
        $registry = Registry::instance();
        $this->httprequest = $registry->getEntry('httprequest');
        $this->params = $this->httprequest->getParams();
        $this->db = Db::factory();
    }

    public function getNews()
    {
        $query = "SELECT * FROM `news` WHERE `id`=".($this->getParam(0));
        $news = array();
        if ($result = $this->db->query($query)) {
            $news = $result->fetch_assoc();
        }
        return $news;
    }

    public function getForm($data) {

        require_once 'HTML/QuickForm.php';
        require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

        $form = new HTML_QuickForm('form', 'POST');
        $defaultValues = array();
        $defaultValues['title']  = $data['title'];
        $defaultValues['text']  = $data['text'];
        $form->setDefaults($defaultValues);

        $form->addElement('text', 'title', 'Имя:', 'size=30');
        $form->addElement('textarea', 'text', 'Текст:', 'rows=7 cols=50');
        $form->addElement('hidden', 'path', '/news/' . $data['id'] . '/save/edit');
        $form->addElement('hidden', 'news_id', $data['id']);
        $form->addElement('reset', 'reset', 'Сброс');
        $form->addElement('submit', 'submit', 'Сохранить');
        return $form;
    }

    public function saveNews() {
        $id = $this->httprequest->get('news_id');
        $title = $this->httprequest->get('title');
        $text = $this->httprequest->get('text');
        $query = "UPDATE `news` SET `title`='" . $title . "', `text` = '" . $text . "' WHERE `id`=".($id);
        if($this->db->query($query) == false || $this->db->error) {
            throw new DbException('Query error: ' . $this->db->error . '<br>Query: ' . $query);
        }

    }

    public function getParam($index) {
        $params = $this->httprequest->getParams();
        return (isset($params[$index])) ? $params[$index] : false;
    }

}

?>