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
 * iDataspace: ��������� Dataspace
 *
 * @package system
 * @version 0.1
 */
interface iDataspace
{
    /**
     * ���������� ��������
     *
     * @param string|integer $key ���� ��� ������� � ��������
     * @param mixed $value ��������
     * @return true
     */
    public function set($key, $value);

    /**
     * ���������� �������� �� �����
     *
     * @param string|intger $key ����
     * @return mixed
     */
    public function get($key);

    /**
     * ������� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return true
     */
    public function delete($key);

    /**
     * ��������� ���������� �� �������� � ������ $key
     *
     * @param string|integer $key ����
     * @return boolean
     */
    public function exists($key);
}
?>