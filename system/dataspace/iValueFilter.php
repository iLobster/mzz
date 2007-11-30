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
 * @subpackage dataspace
 * @version $Id$
*/

/**
 * iValueFilter: интерфейс ValueFilter
 *
 * @package system
 * @subpackage dataspace
 * @version 0.1
 */
interface iValueFilter
{
    /**
     * Применяет фильтр к значению и возвращает его
     *
     * @param mixed $value значение
     * @return mixed
     */
    public function filter($value);
}

?>