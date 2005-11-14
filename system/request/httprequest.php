<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2005
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * HttpRequest: ����� ��� ������ � ���������������� ���������
 * Examples:
 * <code>
 * httprequest::get('var', SC_GET | SC_COOKIE);
 * httprequest::get('var2');
 * </code>
 *
 * @package system
 * @version 0.4
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);

class HttpRequest
{
    /**
     * �����������.
     *
     * @access public
     */
    public function __construct()
    {
        // ����� ���������. �������� ������� ������ ���������.
        trigger_error('Cann\'t create object. ' . __CLASS__ . ' is static. Use "::"', E_USER_ERROR);
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
     * @static
     * @access public
     * @param string $name ��� ����������
     * @param boolean $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public static function get($name, $scope = SC_REQUEST)
    {
        $result = null;

        if ($scope & SC_SERVER) {
            if ( ($result = self::getServer($name)) != null )
            return $result;
        }

        if ($scope & SC_COOKIE) {
            if ( ($result = self::getCookie($name)) != null )
            return $result;
        }


        if ($scope & SC_POST) {
            if ( ($result = self::getPost($name)) != null )
            return $result;
        }

        if ($scope & SC_GET) {
            if ( ($result = self::getGet($name)) != null )
            return $result;
        }

        return $result;
    }

    /**
     * ���������� true ���� ������������ ���������� �������� HTTPS
     *
     * @static
     * @access public
     * @return boolean
     */
    public static function isSecure() {
        $temp = self::getServer('HTTPS');
        return !empty($temp);
    }

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     *
     * @static
     * @access public
     * @return string|null ��������� ��������: GET, HEAD, POST, PUT
     */
    public static function getMethod() {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _GET
     *
     * @static
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private static function getGet($name)
    {
        return ( isset($_GET[$name]) ) ? $_GET[$name] : null;
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _POST
     *
     * @static
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private static function getPost($name)
    {
        return ( isset($_POST[$name]) ) ? $_POST[$name] : null;
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _COOKIE
     *
     * @static
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private static function getCookie($name)
    {
        return ( isset($_COOKIE[$name]) ) ? $_COOKIE[$name] : null;
    }


    /**
     * ����� ��������� ���������� �� ���������������� ������� _SERVER
     *
     * @static
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private static function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }
}
?>