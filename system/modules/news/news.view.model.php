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
    public function __construct()
    {

    }

    public function getNews()
    {
        $registry = Registry::instance();
        $httprequest = $registry->getEntry('httprequest');
        $params = $httprequest->getParams();
        $query = "SELECT * FROM `news` WHERE `id`=".($params[0]);
        $db = DB::factory();
        $news = array();
        if ($result = $db->query($query)) {
            $news = $result->fetch_assoc();
        }
        return $news;
    }

}

?>