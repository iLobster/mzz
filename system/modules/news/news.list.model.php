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
        return array(
            array(
                'title' => 'новость 1',
                'text' => 'текст 1',
                ),
            array(
                'title' => 'новость 2',
                'text' => 'текст 2',
                ),
        );
    }
}

?>