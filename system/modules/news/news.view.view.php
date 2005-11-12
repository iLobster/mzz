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
 * NewsListModel: ��� ��� ������ list ������ news
 *
 * @package news
 * @version 0.1
 */

class newsViewView
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
        $data = $this->model->getNews();
        $this->smarty->assign('news', $data);
        return $this->smarty->fetch('news.view.tpl');
    }
    
    private function setModel($model)
    {
        $this->model = $model;
    }
    
    private function getSmarty()
    {
        return mzzSmarty::getInstance();
    }
}

?>