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
 * mzzPdoStatement: �����, ���������� ����������� Statement � PDO
 *
 * @package system
 * @version 0.1
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
        foreach($data as $key => $val) {
            $this->bindParam(':' . $key, $data[$key]);
        }
    }
}

?>