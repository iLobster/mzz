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
 * @version 0.3
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);

class HttpRequest
{
    /**
     * Private constructor
     *
     * @access private
     */
    private function __construct()
    {
        // todo
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
     * @access public
     * @param string $name ��� ����������
     * @param boolean $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $scope = SC_REQUEST)
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
     * @access public
     * @return boolean
     */
    public function isSecure() {
        $temp = self::getServer('HTTPS');
        return !empty($temp);
    }

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     * ��������� ��������: GET, HEAD, POST, PUT.
     *
     * @access public
     * @return boolean
     */
    public function getMethod() {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _GET
     *
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