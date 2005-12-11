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

class newsViewModel
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

    public function getParam($index) {
        $params = $this->httprequest->getParams();
        return (isset($params[$index])) ? $params[$index] : false;
    }

}

?>