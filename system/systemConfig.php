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
     * ���� �� ����������
     *
     * @static 
     * @var string
     */
    public static $pathToApplication;

    /**
     * ���� �� ����
     *
     * @static 
     * @var string
     */
    public static $pathToSystem;

    /**
     * ���� �� ��������� �����
     *
     * @static 
     * @var string
     */
    public static $pathToTemp;

    /**
     * ���� �� ������ � �������������
     *
     * @static 
     * @var string
     */
    public static $pathToConf;

    /**
     * ��� ������ ���������� � ������������� ���� �� ����
     *
     * @access public
     * @static 
     */
    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__) . '/';
    }
}

?>