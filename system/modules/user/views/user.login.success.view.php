<?php
//
// $Id: news.edit.success.view.php 534 2006-03-16 19:40:58Z mz $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/news/views/news.edit.success.view.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * newsEditSuccessView: вид для успешного метода edit модуля news
 *
 * @package news
 * @version 0.1
 */

class userLoginSuccessView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('user', $this->DAO);
        
        return $this->smarty->fetch('user.success.login.tpl');
    }

}
?>