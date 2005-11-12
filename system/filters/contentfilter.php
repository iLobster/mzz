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
 * contentFilter: фильтр получения и отображения контента
 * 
 * @package system
 * @version 0.1
 */

class contentFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param object $filter_chain объект, содержащий цепочку фильтров
     * @param object $response объект, содержащий информацию, выводимую клиенту в браузер
     */
    public function run($filter_chain, $response)
    {
        $requestParser = requestParser::getInstance();

        $application = $requestParser->get('section');
        $action = $requestParser->get('action');

        $frontcontroller = new frontController($application, $action);
        $template = $frontcontroller->getTemplate();

        $smarty = mzzSmarty::getInstance();
        $response->append($smarty->fetch($template));

        $filter_chain->next();
    }
}

?>