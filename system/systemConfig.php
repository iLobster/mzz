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
     * ��� ������ ���������� � ������������� ���� �� ����
     *
     */
    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__);
    }
}

?>