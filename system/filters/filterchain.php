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
    /**
     * массив с фильтрами
     *
     * @access private
     * @var array
     */
    private $filters = array();
    
    /**
     * счётчик фильтра
     *
     * @access private
     * @var int
     */
    private $counter = -1;
    
    /**
     * объект, содержащий информацию, выводимой клиенту в браузер
     *
     * @access private
     * @var object
     */
    private $response;

    /**
     * конструктор класса
     *
     * @access public
     * @param object $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    
    /**
     * регистрация нового фильтра
     *
     * @access public
     * @param object $filter фильтр для добавления в цепочку
     */
    public function registerFilter($filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * переход к следующему фильтру в цепочке
     *
     * @access public
     */
    public function next()
    {
        $this->counter++;
        
        if(isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response);
        }
    }

    /**
     * запуск цепочки фильтров на выполнение
     *
     * @access public
     */
    public function process()
    {
        $this->next();
    }
}

?>