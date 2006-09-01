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
 * systemConfig: ����������� ����� ��� �������� �����
 *
 * @package system
 *
 */
class systemConfig {

    /**
     * ��������� ������ ��� �������� ������ ��� ���������� � ������� ��
     * ������ ���� �������� ����� ����������,
     * �������� - ������ � ������� ����������. ����� - (driver, dbDsn, dbUser, dbPassword, dbCharset, pdoOptions).
     * ���� �� ������� ����� �� �������� ������� �� ���������
     *
     * @var array
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
     * ���������/���������� �����������
     *
     * @var boolean
     */
    public static $cache;

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