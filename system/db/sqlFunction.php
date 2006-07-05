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
 * sqlFunction: SQL-�������
 *
 * @package system
 * @subpackage db
 * @version 0.1
*/
class sqlFunction
{
    /**
     * ��� �������
     */
    protected $function = null;

    /**
     * �����������
     *
     * @param string $function ��� �������
     *
     */
    public function __construct($function)
    {
        $this->function = $function;
    }

    /**
     * ���������� sql �������
     *
     * @return string|null
     */
    public function toString()
    {
        if(!empty($this->function)) {
            return strtoupper($this->function) . '()';
        }
        return null;
    }

}
?>