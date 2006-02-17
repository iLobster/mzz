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
 * contentFilter: фильтр получения и отображения контента
 *
 * @package system
 * @version 0.2
 */

class contentFilter implements iFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param response $response объект, содержащий информацию, выводимую клиенту в браузер
     */
    public function run(filterChain $filter_chain, $response, $request)
    {
        $toolkit = systemToolkit::getInstance();

        $frontcontroller = new frontController($request);
        $template = $frontcontroller->getTemplate();

        $smarty = $toolkit->getSmarty();
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>