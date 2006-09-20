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
 * timerViewController: ���������� ��� ������ view ������ timer
 *
 * @package modules
 * @subpackage timer
 * @version 0.1
 */

class timerViewController extends simpleController
{
    /**
     * �����������
     *
     */
    public function __construct()
    {
        fileLoader::load('timer/views/timer.view.view');
        parent::__construct();
    }

    /**
     * ���������� ������ �����������
     *
     * @return object
     */
    public function getView()
    {
        $timer = $this->toolkit->getTimer();
        $timer->finish();
        return new timerViewView($timer);
    }
}

?>