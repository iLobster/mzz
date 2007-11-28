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
 * @version $Id$
 */

/**
 * ����� ��� ��������� ������� SELECT SQL-�������� ��� MSSQL
 *
 * @package system
 * @subpackage db
 * @version 0.1
 */

class simpleMssqlSelect extends simpleSelect
{
    /**
     * ������������� �������
     *
     * @param string $alias
     * @return string
     */
    public function quoteAlias($alias)
    {
        return '[' . $alias . ']';
    }

    /**
     * ������������� ��� �����
     *
     * @param string $field
     * @return string
     */
    public function quoteField($field)
    {
        return '[' . str_replace('.', '].[', $field) . ']';
    }

    /**
     * ������������� ��� ������
     *
     * @param string $table
     * @return string
     */
    public function quoteTable($table)
    {
        return '[' . $table . ']';
    }
}

?>