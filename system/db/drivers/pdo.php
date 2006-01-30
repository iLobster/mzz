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
 * mzzPdo: драйвер для работы с базой данных через PDO
 *
 * @package system
 * @version 0.2
 */

fileLoader::load('db/drivers/mzzPdoStatement');

class mzzPdo extends PDO
{
    /**
     * Singleton
     *
     * @var object
     */
    private static $instance;

    /**
     * число запросов к БД
     *
     * @var int
     */
    private $queriesNum = 0;

    /**
     * общее время запросов к БД
     *
     * @var float
     */
    private $queriesTime = 0;

    /**
     * число "приготовленных" запросов (prepared)
     *
     * @var int
     */
    private $queriesPrepared = 0;

    /**
     * Декорируем конструктор PDO: при соединении с БД устанавливается кодировка SQL-базы.
     *
     * @param string $host
     * @param string $username
     * @param string $passwd
     * @param string $dbname
     * @param integer $port
     * @param string $socket
     * @return void
     */
    public function __construct($dsn, $username='', $password='', $charset = '')
    {
        parent::__construct($dsn, $username, $password, systemConfig::$pdoOptions);
        $this->query("SET NAMES `" . $charset . "`");
    }

    /**
     * The singleton method
     *
     * @return object
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
                $classname = __CLASS__;
                $toolkit = systemToolkit::getInstance();
                $config = $toolkit->getConfig();
                $config->load('common');
                $dsn = $config->getOption('db', 'dsn');
                $username = $config->getOption('db', 'user');
                $password = $config->getOption('db', 'password');
                $charset = $config->getOption('db', 'charset');
                // We add options-support later...
                // $options = $config->getOption('db', 'options');
                self::$instance = new $classname($dsn, $username, $password, $charset);
                self::$instance->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('mzzPdoStatement'));
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

    /**
     * Декорирует оригинальный метод для подсчета числа запросов
     *
     * @param string $query запрос к БД
     * @param int $resultmode тип, в котором выдаётся результат
     * @return object
     */
    public function query($query)
    {
        $this->queriesNum++;
        $start_time = microtime(true);
        $result = parent::query($query);
        $this->queriesTime += (microtime(true) - $start_time);
        return $result;
    }

    /**
     * Декорирует оригинальный метод для подсчета числа запросов
     *
     * @param string $query запрос к БД
     * @return object
     */
    public function prepare($query)
    {
        $this->queriesPrepared++;
        $start_time = microtime(true);
        $stmt = parent::prepare($query);
        $this->queriesTime += (microtime(true) - $start_time);
        return $stmt;
    }

    /**
     * Декорирует оригинальный метод для подсчета числа запросов
     *
     * @param string $query запрос к БД
     * @return integer
     */
    public function exec($query)
    {
        $this->queriesNum++;
        $start_time = microtime(true);
        $count = parent::exec($query);
        $this->queriesTime += (microtime(true) - $start_time);
        return $count;
    }

    /**
     * Возвращает значение первого поля из результата запроса
     *
     * @param string $query
     * @return mixed
     */
    public function getOne($query)
    {
        $result = $this->query($query);
        $value = $result->fetch(PDO::FETCH_NUM);
        $result->closeCursor();
        return $value[0];
    }

    /**
     * Возвращает первую строку из результата запроса
     *
     * @param string $query
     * @return array
     */
    public function getRow($query)
    {
        $result = $this->query($query);
        $row = $result->fetch();
        $result->closeCursor();
        return $row;
    }

    /**
     * Возвращает все записи из результата запроса
     *
     * @param string $query
     * @return array
     */
    public function getAll($query)
    {
        $result = $this->query($query);
        $rows = array();
        while ($row = $stmt->fetch()) {
            $rows[] = $row;
        }
        $result->closeCursor();
        return $rows;
    }

    /**
     * метод для получения числа запросов
     *
     * @return int число запросов
     */
    public function getQueriesNum()
    {
        return $this->queriesNum;
    }

    /**
     * метод для получения общего времени выполнения запроса
     *
     * @return float время в секундах
     */
    public function getQueriesTime()
    {
        return $this->queriesTime;
    }

    /**
     * метод получения числа prepared запросов
     *
     * @return int число запросов
     */
    public function getPreparedNum()
    {
        return $this->queriesPrepared;
    }
}

?>