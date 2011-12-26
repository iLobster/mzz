<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage db
 * @version $Id$
*/

fileLoader::load('db/drivers/fPdoStatement');

/**
 * mzzPdo: драйвер для работы с базой данных через PDO
 *
 * @package system
 * @subpackage db
 * @version 0.2.2
 */
class fPdo extends PDO
{
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
     * число "приготовленных" (prepared) запросов
     *
     * @var int
     */
    private $queriesPrepared = 0;

    /**
     * Префикс имени таблиц
     *
     * @var string
     */
    private $tablePrefix;

    /**
     * Декорируем конструктор PDO
     *
     * @param string $dsn       DSN
     * @param string $username  логин к БД
     * @param string $password  пароль к БД
     * @param array $pdoOptions дополнительные опции соединения
     * @return void
     */
    public function __construct($dsn, $username = '', $password = '', $pdoOptions = array())
    {
        parent::__construct($dsn, $username, $password, $pdoOptions);

        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('fPdoStatement'));
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            // из-за проблем вынимания lastInsertId с prepared-запросов в mysql 4.x
            // пользуемся парсером pdo
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $this->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        } catch (PDOException $e) {
            if ($e->getCode() != 'IM001') {
                throw $e;
            }
        }
    }

    /**
     * Декорирует оригинальный метод выполнения sql запросов
     *
     * @param string $query запрос к БД
     * @return fPdoStatement
     */
    public function query($query)
    {
        $this->queriesNum++;
        $start_time = microtime(true);

        $result = parent::query($query);

        if ($result instanceof fPdoStatement) {
            $result->setDbConnection($this);
        }
        $this->addQueriesTime(microtime(true) - $start_time);
        return $result;
    }

    /**
     * Декорирует оригинальный метод для выполнения prepared запросов
     *
     * @param string $query запрос к БД
     * @param array $driver_options атрибуты для PDOStatement
     * @return fPdoStatement
     */
    public function prepare($query, $driver_options = array())
    {
        $this->queriesPrepared++;
        $stmt = parent::prepare($query, $driver_options);
        $stmt->setDbConnection($this);
        return $stmt;
    }

    /**
     * Декорирует оригинальный метод exec
     *
     * @param string $query запрос к БД
     * @return integer
     */
    public function exec($query)
    {
        $this->queriesNum++;
        $start_time = microtime(true);
        $count = parent::exec($query);
        $this->addQueriesTime(microtime(true) - $start_time);
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
    public function getAll($query, $fetch_style = PDO::FETCH_BOTH, $column_index = 0)
    {
        $stmt = $this->query($query);
        // PDO-bug fix
        if ($column_index === 0) {
            $rows = $stmt->fetchAll($fetch_style);
        } else {
            $rows = $stmt->fetchAll($fetch_style, $column_index);
        }
        $stmt->closeCursor();
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
     * метод для прибавления времени к общему времени выполнения запросов
     *
     * @param float $time время в микросекундах в виде действительного числа
     */
    public function addQueriesTime($time)
    {
        $this->queriesTime += $time;
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

    /**
     * метод установки префикса таблиц БД
     *
     * @return string
     */
    public function setTablePrefix($tablePrefix)
    {
        return $this->tablePrefix = $tablePrefix;
    }

    /**
     * метод получения префикса таблиц БД
     *
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->tablePrefix;
    }

}

?>