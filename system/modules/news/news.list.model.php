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

class newsListModel
{
    public function __construct()
    {

    }

    public function getNewsList()
    {
        $query = "SELECT * FROM `news`";
        $db = DB::getInstance();

        $news = array();
        if ($result = $db->query($query)) {
            while ($item = $result->fetch_assoc()) {
                $news[] = $item;
            }
        }

        return $news;
    }
}

?>