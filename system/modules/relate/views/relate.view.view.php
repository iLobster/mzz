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
 * pageViewView: вид для метода view модуля page
 *
 * @package page
 * @version 0.1
 */

class relateViewView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('relate', $this->DAO);
        $this->response->setTitle('Relate');
        return $this->smarty->fetch('relate.view.tpl');
    }

}

?>
