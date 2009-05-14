<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/codegenerator/templates/controller.tpl $
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.tpl 2200 2007-12-06 06:52:05Z zerkms $
 */

/**
 * {{$controller_data.module}}{{$controller_data.name|ucfirst}}Controller
 *
 * @package modules
 * @subpackage {{$controller_data.module}}
 * @version 0.1
 */

class {{$controller_data.module}}{{$controller_data.name|ucfirst}}Controller extends simpleController
{
    protected function getView()
    {
        return $this->smarty->fetch('{{$controller_data.module}}/{{$controller_data.name}}.tpl');
    }
}

?>