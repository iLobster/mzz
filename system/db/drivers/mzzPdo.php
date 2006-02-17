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

define('PDO_AUTOQUERY_INSERT', 0);
define('PDO_AUTOQUERY_UPDATE', 1);

fileLoader::load('db/drivers/mzzPdoStatement');

/**
 * mzzPdo: драйвер для работы с базой данных через PDO
 *
 * @package system
 * @version 0.2
 */
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
     * @param string $dsn DSN
     * @param string $username логин к БД
     * @param string $password пароль к БД
     * @param string $charset кодировка
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
     * Автоматически генерирует insert или update запросы и передает его в prepare()
     *
     * @param string $table имя таблицы
     * @param array $fields массив имен полей
     * @param int $mode тип запроса: PDO_AUTOQUERY_INSERT или PDO_AUTOQUERY_UPDATE
     * @param string $where для UPDATE запрсоов: добавляет WHERE в запрос
     * @return resource
     */
    public function autoPrepare($table, $fields, $mode = PDO_AUTOQUERY_INSERT, $where = false)
    {
        $query = $this->buildInsertUpdateQuery($table, $fields, $mode, $where);
        return $this->prepare($query);
    }

     /**
     * Возвращает запрос для autoPrepare()
     *
     * @param string $table имя таблицы
     * @param array $fields массив имен полей
     * @param int $mode тип запроса: PDO_AUTOQUERY_INSERT или PDO_AUTOQUERY_UPDATE
     * @param string $where для UPDATE запрсоов: добавляет WHERE в запрос
     * @return string
     */
    protected function buildInsertUpdateQuery($table, $fields, $mode, $where = false)
    {
        switch ($mode) {
            case PDO_AUTOQUERY_INSERT:
                $values = array();
                $names = array();
                foreach ($fields as $value) {
                    $names[] = '`' . $value . '`';
                    $values[] = ':' . $value;
                }
                $names = implode(', ', $names);
                $values = implode(', ', $values);
                return 'INSERT INTO `' . $table . '` (' . $names . ') VALUES (' . $values . ')';
            case PDO_AUTOQUERY_UPDATE:
                $field = array();
                foreach ($fields as $value) {
                    $field[] = '`' . $value . '` = :' . $value;
                }
                $field = implode(', ', $field);
                $sql = 'UPDATE `' . $table . '` SET ' . $field;
                if ($where == true) {
                    $sql .= " WHERE " . $where;
                }
                return $sql;
            default:
                throw new mzzRuntimeException("Unknown PDO_AUTOQUERY mode: " . $mode);
        }
    }

    /**
     * Автоматически генерирует INSERT или UPDATE запрос,
     * вызывает prepare() и execute()
     *
     * @param string $table имя таблицы
     * @param array $values массив имен полей
     * @param int $mode тип запроса: PDO_AUTOQUERY_INSERT или PDO_AUTOQUERY_UPDATE
     * @param string $where для UPDATE запрсоов: добавляет WHERE в запрос
     * @return mixed
     */
    function autoExecute($table, $values, $mode = PDO_AUTOQUERY_INSERT, $where = false)
    {
        $stmt = $this->autoPrepare($table, array_keys($values), $mode, $where);
        $stmt->bindArray($values);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
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