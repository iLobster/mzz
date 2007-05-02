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

/**
 * systemConfig: ����������� ����� ��� �������� �����
 *
 * @package system
 * @version 0.2.1
 */
class systemConfig
{
    /**
     * ��������� ������ � ������� ��� ���������� � ����� ��� ����������� ��
     * ���������� ��� ������� ������ ��� ������ ���������� � ������� 'default'
     * ������ ������� �������� ����� ����������, �������� - ������ � �������, ���
     * �����: driver, dbDsn, dbUser, dbPassword, dbCharset, pdoOptions
     *
     * @var array
     * @see DB::factory()
     */
    public static $db;

    /**
     * ���� �� ����������
     *
     * @var string
     */
    public static $pathToApplication;

    /**
     * ���� �� ����
     *
     * @var string
     */
    public static $pathToSystem;

    /**
     * ���� �� ��������� �����
     *
     * @var string
     */
    public static $pathToTemp;

    /**
     * ���� �� ������ � �������������
     *
     * @var string
     */
    public static $pathToConf;

    /**
     * ���� �� �������� � �������
     *
     * @var string
     */
    public static $pathToTests;

    /**
     * ��� ������ ���������� � ������������� ���� �� ����
     *
     */
    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__);
    }
}

?>