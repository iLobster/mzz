<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
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
	$params = requestParser::getInstance()->get('params');
        $query = "SELECT * FROM `news` WHERE `id`=".($params[0]);
        $db = DB::getInstance();
        $news = array();
        if ($result = $db->query($query)) {
            $news = $result->fetch_assoc();
        }
        return $news;
    }
}

?>