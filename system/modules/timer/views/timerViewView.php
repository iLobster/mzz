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
 * timerViewView: вид для метода view модуля timer
 *
 * @package modules
 * @subpackage timer
 * @version 0.1
 */
class timerViewView extends simpleView
{
    public function toString()
    {
        $this->smarty->assign('timer', $this->DAO);
        return $this->smarty->fetch('filter/time.tpl');
    }

}

?>