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
 * resolvingFilter: фильтр для подключения необходимых системе файлов
 *
 * @package system
 * @version 0.1
 */

class resolvingFilter
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
        //fileResolver::includer('template', 'mzzSmarty');
        fileLoader::load('config/configFactory');
        fileLoader::load('request/rewrite');
        fileLoader::load('request/httprequest');
        fileLoader::load('request/requestParser');
        fileLoader::load('frontController');
        fileLoader::load('core/Fs');
        fileLoader::load('core/sectionMapper');
        fileLoader::load('db/dbFactory');
    }
}

?>