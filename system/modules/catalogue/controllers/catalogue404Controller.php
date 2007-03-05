<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/modules/news/controllers/news404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: news404Controller.php 1315 2007-02-20 04:25:19Z zerkms $
 */

/**
 * news404Controller: контроллер для метода 404 модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class catalogue404Controller extends simpleController
{
    public function getView()
    {
        $this->response->setTitle('Ошибка. Запрашиваемая новость или папка не найдена.');
        return $this->smarty->fetch('catalogue/notfound.tpl');
    }
}

?>