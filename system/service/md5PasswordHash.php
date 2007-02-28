<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('service/passwordHash');

/**
 * md5PasswordHash: ����� ��� ����������� ������ � md5
 *
 * @package system
 * @version 0.1
 */
class md5PasswordHash extends PasswordHash
{
    /**
     * ���������� md5-�����������
     *
     * @param string $value �������� ������
     * @return string ��������� ���������� md5-����������� � $value
     */
    public function apply($value)
    {
        return md5($value);
    }
}
?>