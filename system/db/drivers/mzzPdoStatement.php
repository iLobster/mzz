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

/**
 * mzzPdoStatement: �����, ���������� ����������� Statement � PDO
 *
 * @package system
 * @subpackage db
 * @version 0.2.2
 */
class mzzPdoStatement
{
    protected $statement;
    protected $db;

    public function __construct($statement)
    {
        $this->statement = $statement;
    }

    /**
     * ����� ��� ����� ������� ��������
     *
     * @param array $data ������ � �������
     */
    public function bindValues($data)
    {
        foreach ($data as $key => $val) {
            switch (strtolower(gettype($val))) {
                case "boolean":
                $type = PDO::PARAM_BOOL;
                break;
                case "integer":
                $type = PDO::PARAM_INT;
                break;
                case "string":
                $type = PDO::PARAM_STR;
                break;
                case "null":
                $type = PDO::PARAM_NULL;
                break;
                default:
                $type = PDO::PARAM_STR;
                break;
            }
            $this->statement->bindValue(':' . $key, $data[$key], $type);
        }
    }

    /**
     * ����� fetch, ���������� ��� ���������� �� ������������� ������
     *
     * @param integer $how
     * @param integer $orientation
     * @param integer $offset
     * @return array
     */
    public function fetch($how = PDO::FETCH_ASSOC, $orientation = PDO::FETCH_ORI_NEXT, $offset = PDO::FETCH_ORI_ABS)
    {
        return $this->statement->fetch($how, $orientation, $offset);
    }

    /**
     * ������������ ������������ PDOStatement::execute
     *
     * � ������ �������� insert ���������� id ��������� ���������� ������
     * � ��������� ������ - ��������� ���������� �������
     *
     * @param array $parameters � ������� �� �������������������� ��������� ?!
     * @return integer|boolean id ��������� ������ ��� ��������� ���������� �������
     */
    public function execute($parameters = null)
    {
        $start_time = microtime(true);
        $result = $this->statement->execute($parameters);
        $this->db->addQueriesTime(microtime(true) - $start_time);

        $lastInsertId = $this->db->lastInsertId();

        return ($result && $lastInsertId) ? $lastInsertId : $result;
    }

    /**
     * ��������� ������������ mzzPdo ��� ����������� mzzPdoStatement
     *
     * @param mzzPdo $db ��������� �������� ���������� � �����
     * @return void
     */
    public function setDbConnection(mzzPdo $db)
    {
        $this->db = $db;
    }

    public function __call($name, $args)
    {
        return call_user_func_array(array($this->statement, $name), $args);
    }
}

?>