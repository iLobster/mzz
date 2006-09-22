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
 * @version 0.2.1
 */
class mzzPdoStatement extends PDOStatement
{
    /**
     * ����� ��� ����� ������� ��������
     * � ���� ������������ ��� ��� ������� ����� ���������� ��� ������������ �� ���������
     * �.�. ����� ��������� ����������� ������� ����� ��� ������ �������
     *
     * @param array $data ������ � �������
     */
    public function bindArray($data)
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
            $this->bindParam(':' . $key, $data[$key], $type);
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
        return parent::fetch($how, $orientation, $offset);
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
        $result = parent::execute($parameters);
        $this->db->addQueriesTime(microtime(true) - $start_time);

        $lastInsertId = $this->db->lastInsertId();

        return ($result && $lastInsertId) ? $lastInsertId : $result;
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
    public function setDbConnection(mzzPdo $db)
    {
        $this->db = $db;
    }
}

?>