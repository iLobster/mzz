<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
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