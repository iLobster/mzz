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

class jip
{

    public function __construct($section, $id, $module, $type)
    {

    }
    public function draw()
    {
        $toolkit = systemToolkit::getInstance();
        $smarty = $toolkit->getSmarty();
        //return $smarty->fetch('template');
    }
}
?>