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
 * ResolvingFilter: фильтр для подключения необходимых системе файлов
 *
 * @package system
 * @version 0.1
 */

class ResolvingFilter
{
    /**
     * запуск фильтра на исполнение
     *
     * @param filterChain $filter_chain объект, содержащий цепочку фильтров
     * @param response $response объект, содержащий информацию, выводимую клиенту в браузер
     */
    public function run($filter_chain, $response)
    {
        $this->resolve();
        $filter_chain->next();
    }

    /**
     * подключение необходимых файлов
     *
     * @access private
     */
    private function resolve()
    {
        FileLoader::load('config/Config');
        FileLoader::load('request/Rewrite');
        FileLoader::load('request/HttpRequest');
        FileLoader::load('request/RequestParser');
        FileLoader::load('FrontController');
        FileLoader::load('core/Fs');
        FileLoader::load('core/SectionMapper');
        FileLoader::load('db/DbFactory');
        FileLoader::load('simple/simple.view');
    }
}

?>