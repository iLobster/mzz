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

class resolvingFilter
{
    public function run($filter_chain, $response)
    {
        $this->resolve();
        $filter_chain->next();
    }

    private function resolve()
    {
        fileResolver::includer('config', 'configFactory');
        fileResolver::includer('request', 'requestParser');
        fileResolver::includer('frontcontroller', 'frontcontroller');
        fileResolver::includer('errors', 'error');
        fileResolver::includer('template', 'mzzSmarty');
        fileResolver::includer('core', 'File');
        fileResolver::includer('request', 'httprequest');
        fileResolver::includer('db', 'dbFactory');
    }
}

?>