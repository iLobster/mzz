<?php
//
// $Id: controller.tpl 1 2006-09-05 21:03:12Z zerkms $
// $URL: http://svn.web/repository/mzz/system/codegenerator/templates/controller.tpl $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * {{$controller_data.controllername}}: ���������� ��� ������ {{$controller_data.action}} ������ {{$controller_data.module}}
 *
 * @package modules
 * @subpackage {{$controller_data.module}}
 * @version 0.1
 */

class {{$controller_data.controllername}} extends simpleController
{
    public function __construct()
    {
        /* 
        put your fileloader section here
        */
        parent::__construct();
    }

    public function getView()
    {
        
        return new {{$controller_data.viewname}}();
    }
}

?>