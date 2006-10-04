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
 * sqlFunction: SQL-функция
 *
 * @package system
 * @subpackage db
 * @version 0.1
*/
class sqlFunction
{
    /**
     * Имя функции
     */
    protected $function = null;

    /**
     * Аргументы
     */
    protected $arguments = null;

    /**
     * Конструктор
     *
     * @param string $function имя функции
     *
     */
    public function __construct($function, $arguments = null)
    {
        $this->function = $function;
        if(is_array($arguments)) {
            $this->arguments = "'" . implode("', '", $arguments) . "'";
        } elseif(is_scalar($arguments)) {
            $this->arguments =  "'" . $arguments . "'";
        }

    }

    /**
     * Возвращает sql функцию
     *
     * @return string|null
     */
    public function toString()
    {
        if(!empty($this->function)) {
            return strtoupper($this->function) . '(' . $this->arguments . ')';
        }
        return null;
    }

}
?>