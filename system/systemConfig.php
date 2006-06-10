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
 */
class systemConfig {

    /**
     * ��� �������� ��
     *
     * @var string
     */
    public static $dbDriver;

    /**
     * Data Source Name
     *
     * @var string
     */
    public static $dbDsn;

    /**
     * ��� ������������ ��� ������� � ��
     *
     * @var string
     */
    public static $dbUser;

    /**
     * ������ ��� ������� � ��
     *
     * @var string
     */
    public static $dbPassword;

    /**
     * ��������� ��
     *
     * @var string
     */
    public static $dbCharset;

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
     * ����� ���������� � ����� ������ ��� PDO
     *
     * @var array
     */
    public static $pdoOptions;

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