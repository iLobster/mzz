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
 * mzzPdo: ������� ��� ������ � ����� ������ ����� PDO
 *
 * @package system
 * @version 0.2
 */
define('PDO_AUTOQUERY_INSERT', 0);
define('PDO_AUTOQUERY_UPDATE', 1);

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
     * ����� �������� � ��
     *
     * @var int
     */
    private $queriesNum = 0;

    /**
     * ����� ����� �������� � ��
     *
     * @var float
     */
    private $queriesTime = 0;

    /**
     * ����� "��������������" �������� (prepared)
     *
     * @var int
     */
    private $queriesPrepared = 0;

    /**
     * ���������� ����������� PDO: ��� ���������� � �� ��������������� ��������� SQL-����.
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
     * ���������� ������������ ����� ��� �������� ����� ��������
     *
     * @param string $query ������ � ��
     * @param int $resultmode ���, � ������� ������� ���������
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
     * ���������� ������������ ����� ��� �������� ����� ��������
     *
     * @param string $query ������ � ��
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
     * ������������� ���������� insert ��� update ������� � �������� ��� � prepare()
     *
     * @param string $table ��� �������
     * @param array $table_fields ������ ���� �����
     * @param int $mode ��� �������: PDO_AUTOQUERY_INSERT ��� PDO_AUTOQUERY_UPDATE
     * @param string $where ��� UPDATE ��������: ��������� WHERE � ������
     * @return resource
     */
    public function autoPrepare($table, $fields, $mode = PDO_AUTOQUERY_INSERT, $where = false)
    {
        $query = $this->buildInsertUpdateQuery($table, $fields, $mode, $where);
        return $this->prepare($query);
    }

     /**
     * ���������� ������ ��� autoPrepare()
     *
     * @param string $table ��� �������
     * @param array $table_fields ������ ���� �����
     * @param int $mode ��� �������: PDO_AUTOQUERY_INSERT ��� PDO_AUTOQUERY_UPDATE
     * @param string $where ��� UPDATE ��������: ��������� WHERE � ������
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
                $names = implode(',', $names);
                $values = implode(',', $values);
                return 'INSERT INTO `' . $table . '` (' . $names . ') VALUES (' . $values . ')';
            case PDO_AUTOQUERY_UPDATE:
                $field = array();
                foreach ($fields as $value) {
                    $field[] = '`' . $value . '` = :' . $value;
                }
                $field = implode(',', $field);
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
     * ���������� ������������ ����� ��� �������� ����� ��������
     *
     * @param string $query ������ � ��
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
     * ���������� �������� ������� ���� �� ���������� �������
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
     * ���������� ������ ������ �� ���������� �������
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
     * ���������� ��� ������ �� ���������� �������
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
     * ����� ��� ��������� ����� ��������
     *
     * @return int ����� ��������
     */
    public function getQueriesNum()
    {
        return $this->queriesNum;
    }

    /**
     * ����� ��� ��������� ������ ������� ���������� �������
     *
     * @return float ����� � ��������
     */
    public function getQueriesTime()
    {
        return $this->queriesTime;
    }

    /**
     * ����� ��������� ����� prepared ��������
     *
     * @return int ����� ��������
     */
    public function getPreparedNum()
    {
        return $this->queriesPrepared;
    }
}

?>