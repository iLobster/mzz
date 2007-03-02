<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueViewController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueViewController.php 641 2007-03-02 22:39:51Z zerkms $
 */

/**
 * catalogueViewController: контроллер для метода view модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueViewController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        
        $items = $catalogueMapper->searchAll();
        $this->smarty->assign('items', $items);
        return $this->smarty->fetch('catalogue/view.tpl');
    }
}

?>