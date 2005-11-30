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
 * NewsListModel: вид для метода list модуля news
 *
 * @package news
 * @version 0.1
 */

class newsListView
{
    private $model;
    private $smarty;

    public function __construct($model)
    {
        $this->setModel($model);
        $this->smarty = self::getSmarty();
    }

    public function toString()
    {
        $data = $this->model->getNewsList();
        $this->smarty->assign('news', $data);
        return $this->smarty->fetch('news.list.tpl');
    }

    private function setModel($model)
    {
        $this->model = $model;
    }

    private function getSmarty()
    {
        $registry = Registry::instance();
        return $registry->getEntry('smarty');
    }
}

?>