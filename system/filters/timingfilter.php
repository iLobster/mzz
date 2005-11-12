<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * timingFilter: фильтр для тайминга
 * 
 * @package system
 * @version 0.1
 */

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
        $start_time = microtime(true);

        $filter_chain->next();
        
        // сделать чтобы читал из шаблона формат
        $response->append('<br><hr size=1><font size=-2>' . (microtime(true)-$start_time) . '</font>');
        
    }
}

?>