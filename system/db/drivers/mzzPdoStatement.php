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
 * mzzPdoStatement: класс, заменяющий стандартный Statement в PDO
 *
 * @package system
 * @subpackage db
 * @version 0.2.3
 */
class mzzPdoStatement extends PDOStatement
{
    /**
     * Метод для бинда массива значений
     *
     * @param array $data массив с данными
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
            $this->bindValue(':' . $key, $data[$key], $type);
        }
    }

    /**
     * Метод fetch, изменяющий вид результата на ассоциативный массив
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
     * Альтернатива стандартному PDOStatement::execute
     *
     * В случае удачного insert возвращает id последней вставленно записи
     * В противном случае - результат выполнения запроса
     *
     * @param array $parameters в мануале не продокументированные параметры ?!
     * @return integer|boolean id последней записи или результат выполнения запроса
     */
    public function execute($parameters = null)
    {
        $start_time = microtime(true);
        $result = parent::execute($parameters);
        $this->db->addQueriesTime(microtime(true) - $start_time);

        $lastInsertId = null;

        try {
            $lastInsertId = $this->db->lastInsertId();
        } catch (PDOException $e) {
            if ($e->getCode() != 'IM001') {
                throw $e;
            }
        }

        return ($result && $lastInsertId) ? $lastInsertId : $result;
    }

    /**
     * Установка соответствия mzzPdo для конкретного mzzPdoStatement
     *
     * @param mzzPdo $db экземпляр драйвера соединения с базой
     * @return void
     */
    public function setDbConnection(mzzPdo $db)
    {
        $this->db = $db;
    }
}

?>