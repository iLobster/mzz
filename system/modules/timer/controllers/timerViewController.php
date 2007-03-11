<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * timerViewController: ���������� ��� ������ view ������ timer
 *
 * @package modules
 * @subpackage timer
 * @version 0.1
 */
class timerViewController extends simpleController
{
    public function getView()
    {
        $timer = $this->toolkit->getTimer();
        $timer->finish();
        $this->smarty->assign('timer', $timer);

        $prefix = $this->request->get('tplPrefix', 'string');
        if (!empty($prefix)) {
            $prefix .= '/';
        }
        return $this->smarty->fetch('filter/' . $prefix . 'time.tpl');
    }
}

?>