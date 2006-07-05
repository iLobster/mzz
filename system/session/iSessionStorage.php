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
 * @subpackage session
 * @version $Id$
*/

/**
 * iSessionStorage: ��������� ��������� ������
 *
 * @package system
 * @subpackage session
 * @version 0.1
*/
interface iSessionStorage
{
    /**
     * �������� ��������� ������
     *
     * @return bool
     */
    function storageOpen();

    /**
     * �������� ��������� ������
     *
     * @return bool
     */
    function storageClose();

    /**
     * ������ ������ �� ���������
     *
     * @param string $sid ������������� ������
     * @return string
     */
    function storageRead($sid);

    /**
     * ������ �������� ������ � ���������
     *
     * @param string $sid   ������������� ������
     * @param string $value �������� ������
     * @return string
     */
    function storageWrite($sid, $value);

    /**
     * ����������� ������ �� ���������
     *
     * @param string $sid ������������� ������
     * @return string
     */
    function storageDestroy($sid);

    /**
     * ��������� ����������������� ����� ������
     *
     * @param string $maxLifeTime ����� ����� ������ � ��������
     * @return string
     */
    function storageGc($maxLifeTime);
}


?>