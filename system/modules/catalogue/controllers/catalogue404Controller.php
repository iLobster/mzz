<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogue404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogue404Controller.php 657 2007-03-05 21:47:20Z zerkms $
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