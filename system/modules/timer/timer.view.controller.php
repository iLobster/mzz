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
        //fileLoader::load('news.view.model');
        fileLoader::load('timer.view.view');
    }

    public function getView()
    {
        $registry = Registry::instance();
        $timer = $registry->getEntry('sysTimer');
        $timer->finish();
        var_dump($timer);
        return new timerViewView(null);
    }
}

?>