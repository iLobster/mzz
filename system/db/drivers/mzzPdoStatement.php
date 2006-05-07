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
 * mzzPdoStatement: класс, заменяющий стандартный Statement в PDO
 *
 * @package system
 * @version 0.2
 */
class mzzPdoStatement extends PDOStatement
{
    /**
     * Метод для бинда массива значений
     * в силу особенностей пхп как обычные бинды переменных его использовать не получится
     * т.е. после изменения содержимого массива нужно его заново биндить
     *
     * @param array $data массив с данными
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
    public function execute($parameters = array())
    {
        $result = parent::execute($parameters);

        $db = DB::factory();

        $lastInsertId = $db->lastInsertId();

        return (!$result || !$lastInsertId) ? $result : $lastInsertId;
    }
}

?>