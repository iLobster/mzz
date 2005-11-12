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
    private $counter = -1;
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function registerFilter($filter)
    {
        $this->filters[] = $filter;
    }

    public function next()
    {
        $this->counter++;
        
        if(isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response);
        }
    }

    public function process()
    {
        $this->counter = -1;
        $this->next();
    }
}

?>