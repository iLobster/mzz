<?php
/**
 * $URL: http://svn.web/repository/mzz/docs/standart_header.txt $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: standart_header.txt 1 2006-09-05 21:03:12Z zerkms $
*/

/**
 * {{$view_data.viewname}}: вид для метода {{$view_data.action}} модуля {{$view_data.module}}
 *
 * @package modules
 * @subpackage {{$view_data.module}}
 * @version 0.1
 */

class {{$view_data.viewname}} extends simpleView
{
    public function toString()
    {
        return $this->smarty->fetch('{{$view_data.tplname}}');
    }
}

?>