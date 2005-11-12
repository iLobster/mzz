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
 * core: ядро mzz
 * 
 * @package system
 * @version 0.1
 */

fileResolver::includer('core', 'response');
fileResolver::includer('filters', 'filterchain');
fileResolver::includer('filters', 'timingfilter');
fileResolver::includer('filters', 'contentfilter');
fileResolver::includer('filters', 'resolvingfilter');

class core
{
    /**
     * запуск приложения
     * 
     * @access public
     *
     */
    public function run()
    {
        $response = new response();

        $filter_chain = new filterChain($response);

        $filter_chain->registerFilter(new timingFilter());
        $filter_chain->registerFilter(new resolvingFilter());
        $filter_chain->registerFilter(new contentFilter());

        $filter_chain->process();
        //$filter_chain->registerFilter(new );

        $response->send();
    }
}

?>