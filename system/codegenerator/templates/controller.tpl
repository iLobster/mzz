<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) {{"Y"|date}}
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * {{$controller_data.controllername}}: контроллер для метода {{$controller_data.action}} модуля {{$controller_data.module}}
 *
 * @package modules
 * @subpackage {{$controller_data.module}}
 * @version 0.1
 */

class {{$controller_data.controllername}} extends simpleController
{
    public function getView()
    {
        return $this->smarty->fetch('{{$controller_data.module}}/{{$controller_data.action}}.tpl');
    }
}

?>