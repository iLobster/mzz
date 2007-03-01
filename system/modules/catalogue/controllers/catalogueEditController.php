<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 1309 2007-02-13 05:54:09Z zerkms $
 */

/**
 * catalogueEditController: контроллер для метода edit модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueEditController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        
        $types = $catalogueMapper->getAllTypes();
        $properties = $catalogueMapper->getAllProperties();
        
        $this->smarty->assign('types', $types);
        $this->smarty->assign('properties', $properties);
        return $this->smarty->fetch('catalogue/edit.tpl');
    }
}
?>