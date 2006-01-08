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
    private $start;
    private $finish;
    private $queries_start;
    private $queries_finish;
    private $queries_time_start;
    private $queries_time_finish;
    private $prepared_start;
    private $prepared_finish;
    public function __construct()
    {
        $this->db = Db::factory();
    }
    public function start()
    {
        $this->start = microtime(true);
        $this->queries_start = $this->db->getQueriesNum() - 1;
        $this->queries_time_start = $this->db->getQueriesTime();
        $this->prepared_start = $this->db->getPreparedNum();
    }
    public function finish()
    {
        $this->finish = microtime(true);
        $this->queries_finish = $this->db->getQueriesNum();
        $this->queries_time_finish = $this->db->getQueriesTime();
        $this->prepared_finish = $this->db->getPreparedNum();
    }
    public function getPeriod()
    {
        return $this->finish - $this->start;
    }
    public function getQueriesNum()
    {
        return $this->queries_finish - $this->queries_start;
    }
    public function getQueriesTime()
    {
        return $this->queries_time_finish - $this->queries_time_start;
    }
    public function getPreparedNum()
    {
        return $this->prepared_finish - $this->prepared_start;
    }
}

?>