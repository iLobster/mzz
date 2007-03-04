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
 * catalogueCreatrFolderController: контроллер для метода creatrFolder модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueCreatrFolderController extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('catalogue/creatrFolder.tpl');
    }
}

?>