<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/timer/timer.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: timer.php 2375 2008-02-05 00:45:41Z mz $
 */

/**
 * timer: таймер
 * фиксирует время выполнения скрипта, количество обычных и подготовленных запросов и
 * время их выполнения
 *
 * @package timer
 * @version 0.1.1
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
     * Объект шаблонного движка
     *
     * @var fSmarty
     */
    protected $smarty;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $toolkit = systemToolkit::getInstance();
        $this->smarty = $toolkit->getSmarty();
        $this->db = fDB::factory();
    }

    /**
     * Устанавливает таймер в текущие значения в начале
     *
     */
    public function start()
    {
        $this->start = microtime(true);
        $this->queries_start = $this->db->getQueriesNum();
        $this->queries_time_start = $this->db->getQueriesTime();
        $this->prepared_start = $this->db->getPreparedNum();
    }

    /**
     * Устанавливает таймер в текущие значения в конце
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

    /**
     * Возвращает выполненый шаблон таймера
     *
     * @param string $tpl шаблон вывода данных
     * @return string
     */
    public function toString($tpl = 'timer/timer.tpl')
    {
        $this->finish();
        return $this->smarty->fetch($tpl);
    }

}

?>