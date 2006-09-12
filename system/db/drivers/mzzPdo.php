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

define('PDO_AUTOQUERY_INSERT', 0);
define('PDO_AUTOQUERY_UPDATE', 1);

fileLoader::load('db/drivers/mzzPdoStatement');

/**
 * mzzPdo: ������� ��� ������ � ����� ������ ����� PDO
 *
 * @package system
 * @subpackage db
 * @version 0.2.1
 */
class mzzPdo extends PDO
{
    /**
     * Array of Different Instances
     *
     * @var object
     */
    private static $instances;

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
     * �������� �������� ����������
     *
     * @var string
     */
    private $alias;

    /**
     * ���������� ����������� PDO: ��� ���������� � �� ��������������� ��������� SQL-����.
     *
     * @param string $alias     ��� ������ � ������� � ����������
     * @param string $dsn       DSN
     * @param string $username  ����� � ��
     * @param string $password  ������ � ��
     * @param string $charset   ���������
     * @return void
     */
    public function __construct($alias, $dsn, $username='', $password='', $charset = '', $pdoOptions = array())
    {
        parent::__construct($dsn, $username, $password, $pdoOptions);
        $this->query("SET NAMES '" . $charset . "'");
    }

    /**
     * The singleton method
     *
     * @param string $alias ���� ������� [systemConfig::$db] � ������� � ����������
     * @return object
     */
    public static function getInstance($alias = 'default')
    {
        if(!isset(self::$instances[$alias])) {
            $classname = __CLASS__;
            $dsn      = isset(systemConfig::$db[$alias]['dsn']) ? systemConfig::$db[$alias]['dsn'] : systemConfig::$db['default']['dsn'];
            $username = isset(systemConfig::$db[$alias]['user']) ? systemConfig::$db[$alias]['user'] : systemConfig::$db['default']['user'];
            $password = isset(systemConfig::$db[$alias]['password']) ? systemConfig::$db[$alias]['password'] : systemConfig::$db['default']['password'];
            $charset  = isset(systemConfig::$db[$alias]['charset']) ? systemConfig::$db[$alias]['charset'] : systemConfig::$db['default']['charset'];
            $pdoOptions = isset(systemConfig::$db[$alias]['pdoOptions']) ? systemConfig::$db[$alias]['pdoOptions'] : systemConfig::$db['default']['pdoOptions'];

            self::$instances[$alias] = new $classname($alias, $dsn, $username, $password, $charset, $pdoOptions);
            self::$instances[$alias]->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('mzzPdoStatement'));
            self::$instances[$alias]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            self::$instances[$alias]->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        }

        return self::$instances[$alias];
    }

    /**
     * ���������� ������������ ����� ��� �������� ����� ��������
     *
     * @param string $query ������ � ��
     * @return object
     */
    public function query($query)
    {
        $this->queriesNum++;
        $start_time = microtime(true);
        $result = parent::query($query);
        $this->addQueriesTime(microtime(true) - $start_time);
        return $result;
    }

    /**
     * ���������� ������������ ����� ��� �������� ����� ��������
     *
     * @param string $query ������ � ��
     * @param array $driver_options �������� ��� PDOStatement
     * @return object
     */
    public function prepare($query, $driver_options = array())
    {
        $this->queriesPrepared++;
        $stmt = parent::prepare($query, $driver_options);
        return $stmt;
    }

    /**
     * ������������� ���������� insert ��� update ������� � �������� ��� � prepare()
     *
     * @param string $table ��� �������
     * @param array $fields ������ ���� �����
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
     * @param array $fields ������ ���� �����
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
     * ������������� ���������� INSERT ��� UPDATE ������,
     * �������� prepare() � execute()
     *
     * @param string $table ��� �������
     * @param array $values ������ ���� �����
     * @param int $mode ��� �������: PDO_AUTOQUERY_INSERT ��� PDO_AUTOQUERY_UPDATE
     * @param string $where ��� UPDATE ��������: ��������� WHERE � ������
     * @return mixed
     */
    function autoExecute($table, $values, $mode = PDO_AUTOQUERY_INSERT, $where = false)
    {
        $stmt = $this->autoPrepare($table, array_keys($values), $mode, $where);
        $stmt->bindArray($values);
        $result = $stmt->execute();
        $stmt->closeCursor();
        if ($mode == PDO_AUTOQUERY_INSERT) {
            return $this->lastInsertId();
        }

        return $result;
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
        $this->addQueriesTime(microtime(true) - $start_time);
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
        $stmt = $this->query($query);
        $rows = array();
        while ($row = $stmt->fetch()) {
            $rows[] = $row;
        }
        $stmt->closeCursor();
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
     * ����� ��� ����������� ������� � ������ ������� ���������� ��������
     *
     * @param float $time ����� � ������������� � ���� ��������������� �����
     */
    public function addQueriesTime($time)
    {
        $this->queriesTime += $time;
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

    /**
     * ����� ��������� �������� �������� ����������
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

}

?>