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
 * timerViewController: контроллер для метода view модуля timer
 *
 * @package timer
 * @version 0.1
 */

class timerViewController
{
    public function __construct()
    {
        fileLoader::load('timer/views/timer.view.view');
    }

    public function getView()
    {
        $toolkit = systemToolkit::getInstance();
        $timer = $toolkit->getTimer();
        $timer->finish();
        return new timerViewView($timer);
    }
}

?>