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
    public function run($filter_chain, $response)
    {
        $start_time = microtime(true);

        $filter_chain->next();
        
        $response->append(microtime(true)-$start_time);
    }
}

?>