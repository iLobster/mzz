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
 * PasswordHash: ����������� ����� PasswordHash
 *
 * @package system
 * @version 0.1
 */
abstract class passwordHash
{
    /**
     * ���������� �����������
     *
     * @param string $value �������� ������
     * @return string ��������� ���������� ����������� � $value
     */
    public function apply($value)
    {
        return $value;
    }
}
?>