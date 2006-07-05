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
 * sessionFilter: фильтр для старта сессии
 *
 * @package system
 * @subpackage filters
 * @version 0.2
 */

fileLoader::load('session');

class sessionFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param httpResponse $response объект, содержащий информацию, выводимую клиенту в браузер
     * @param iRequest $request
     */
    public function run(filterChain $filter_chain, $response, iRequest $request)
    {
        /*
        $toolkit = systemToolkit::getInstance();
        возможно сессия будет получаться из тулкита
        */
        $session = new session;
        $session->start();

        $filter_chain->next();

        //$session->stop(); ??
    }
}

?>