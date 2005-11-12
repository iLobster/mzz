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
 * filterChain: реализация цепочки обязанностей для фильтров
 * 
 * @package system
 * @version 0.1
 */

class filterChain
{
    private $filters = array();
    private $counter = 0;
    private $response;

    function __construct($response)
    {
        $this->response = $response;
    }

    function registerFilter($filter)
    {
        $this->filters[] = $filter;
    }

    function next()
    {
        if(isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response);
        }

        $this->counter++;
    }

    function process()
    {
        $this->next();
    }
}

?>