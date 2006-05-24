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
 * timer: таймер
 * засекает время, считает запросы к БД
 *
 * @package timer
 * @version 0.1
 */

class timer
{
    private $db;
    /**#@+
     * @var integer
     */
    private $queries_start;
    private $queries_finish;
    private $prepared_start;
    private $prepared_finish;
    /**#@-*/

    /**#@+
     * @var float
     */
    private $start;
    private $finish;
    private $queries_time_start;
    private $queries_time_finish;
    /**#@-*/

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->db = Db::factory();
    }

    /**
     * Устанавливает таймер в текущие значения
     *
     */
    public function start()
    {
        $this->start = microtime(true);
        $this->queries_start = $this->db->getQueriesNum() - 1;
        $this->queries_time_start = $this->db->getQueriesTime();
        $this->prepared_start = $this->db->getPreparedNum();
    }

    /**
     * Устанавливает таймер в текущие значения
     *
     */
    public function finish()
    {
        $this->finish = microtime(true);
        $this->queries_finish = $this->db->getQueriesNum();
        $this->queries_time_finish = $this->db->getQueriesTime();
        $this->prepared_finish = $this->db->getPreparedNum();
    }

    /**
     * Возвращает разницу между временем вызова finish() и start()
     *
     * @return float
     */
    public function getPeriod()
    {
        return $this->finish - $this->start;
    }

    /**
     * Возвращает разницу между количеством запросов к БД
     * от вызова finish() до вызова start()
     *
     * @return integer
     */
    public function getQueriesNum()
    {
        return $this->queries_finish - $this->queries_start;
    }

    /**
     * Возвращает разницу между временем выполнения запросов к БД ish()
     * от вызова finish() до вызова start()
     *
     * @return float
     */
    public function getQueriesTime()
    {
        return $this->queries_time_finish - $this->queries_time_start;
    }

    /**
     * Возвращает разницу между количеством подготовленных запросов к БД
     * от вызова finish() до вызова start()
     *
     * @return integer
     */
    public function getPreparedNum()
    {
        return $this->prepared_finish - $this->prepared_start;
    }
}

?>