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
 * @subpackage request
 * @version $Id$
*/

/**
 * iRoute: ��������� ������� ��� ��������������.
 * ��� ���������� PATH � �������� ������� ���������� ��� ������������.
 *
 * @package system
 * @subpackage request
 * @version 0.1
 */
interface iRoute
{
    /**
     * �������� ���������� PATH � ��������.
     *
     * @param string $path ���������� path �� URL
     * @return array|false
     */
    public function match($path);

    /**
     * ��������� ����� �����. ��������������� ������ ���� ���
     *
     * @param string $name
     */
    public function setName($name);
}

?>