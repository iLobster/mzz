<?php
/**
 * $URL: http://svn.sandbox/repository/mzz/system/modules/tags/controllers/tags404Controller.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: tags404Controller.php 1121 2007-11-30 04:31:39Z zerkms $
 */

/**
 * simple404Controller: контроллер для метода 404 модуля simple
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.2
 */

class tags404Controller extends simpleController
{

    protected function getView()
    {
        return $this->smarty->fetch('tags/404.tpl');
    }
}

?>