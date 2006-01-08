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
 * timingFilter: фильтр для подсчета времени выполнения скрипта
 *
 * @package system
 * @version 0.1.1
 */

fileLoader::load('timer/timer');

class timingFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param response $response объект, содержащий информацию, выводимую клиенту в браузер
     */
    public function run($filter_chain, $response)
    {
        $timer = new timer();
        $timer->start();

        $registry = Registry::instance();
        $registry->setEntry('sysTimer', $timer);

        $filter_chain->next();

        $timer->finish();
    }
}

?>