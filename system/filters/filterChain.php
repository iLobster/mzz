<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * filterChain: реализация цепочки обязанностей для фильтров
 *
 * @package system
 * @subpackage filters
 * @version 0.1
 */

class filterChain
{
    /**
     * массив с фильтрами
     *
     * @var array
     */
    private $filters = array();

    /**
     * счётчик фильтра
     *
     * @var int
     */
    private $counter = -1;

    /**
     * объект, содержащий информацию, выводимой клиенту в браузер
     *
     * @var response
     */
    private $response;

    /**
     * Request
     *
     * @var object
     */
    private $request;

    /**
     * конструктор класса
     *
     * @param response $response
     * @param object $request
     */
    public function __construct($response, $request)
    {
        $this->response = $response;
        $this->request = $request;
    }


    /**
     * регистрация нового фильтра
     *
     * @param object $filter фильтр для добавления в цепочку
     */
    public function registerFilter(iFilter $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * переход к следующему фильтру в цепочке
     *
     */
    public function next()
    {
        $this->counter++;

        if (isset($this->filters[$this->counter])) {
            $this->filters[$this->counter]->run($this, $this->response, $this->request);
        }
    }

    /**
     * запуск цепочки фильтров на выполнение
     *
     */
    public function process()
    {
        $this->next();
    }
}

?>