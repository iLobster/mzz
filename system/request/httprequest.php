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
 * HttpRequest: класс для работы с суперглобальными массивами
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
     * Конструктор.
     *
     * @access public
     */
    public function __construct()
    {
        // Класс статичный. Создание объекта класса запрещено.
        trigger_error('Cann\'t create object. ' . __CLASS__ . ' is static. Use "::"', E_USER_ERROR);
    }

    /**
     * Метод получения переменной из суперглобального массива
     *
     * @static
     * @access public
     * @param string $name имя переменной
     * @param boolean $scope бинарное число, определяющее в каких массивах искать переменную
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
     * Возвращает true если используется защищенный протокол HTTPS
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
     * Метод возвращает протокол, который был использован для передачи данных.
     *
     * @static
     * @access public
     * @return string|null возможные варианты: GET, HEAD, POST, PUT
     */
    public static function getMethod() {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * Метод получения переменной из суперглобального массива _GET
     *
     * @static
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private static function getGet($name)
    {
        return ( isset($_GET[$name]) ) ? $_GET[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _POST
     *
     * @static
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private static function getPost($name)
    {
        return ( isset($_POST[$name]) ) ? $_POST[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _COOKIE
     *
     * @static
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private static function getCookie($name)
    {
        return ( isset($_COOKIE[$name]) ) ? $_COOKIE[$name] : null;
    }


    /**
     * Метод получения переменной из суперглобального массива _SERVER
     *
     * @static
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private static function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }
}
?>