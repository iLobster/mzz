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
 * @version 0.1
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
        foreach($data as $key => $val) {
            $this->bindParam(':' . $key, $data[$key]);
        }
    }
}

?>