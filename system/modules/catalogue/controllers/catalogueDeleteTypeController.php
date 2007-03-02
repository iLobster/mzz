<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueDeleteTypeController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueDeleteTypeController.php 637 2007-03-02 03:07:52Z zerkms $
 */

/**
 * catalogueDeleteTypeController: контроллер для метода deleteType модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueDeleteTypeController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('catalogue/deleteType.tpl');
    }
}

?>