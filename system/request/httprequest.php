<?php
/**
 * HttpRequest: класс для работы с суперглобальными массивами
 *
 * @example httprequest::get('var', SC_GET | SC_COOKIE)
 * @example httprequest::get('var2')
 * @version 0.2
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
     * Метод получения переменной из суперглобального массива
     *
     * @access public
     * @return string|null
     */
    public function get($name, $scope = SC_REQUEST)
    {
        $result = null;
        $get = self::getGet($name);
        $post = self::getPost($name);
        $cookie = self::getCookie($name);
        $server = self::getServer($name);
        
        if ($scope & SC_GET && isset($get)) {
            $result = self::getGet($name);
        }
        
        if ($scope & SC_POST && isset($post)) {
            $result = self::getPost($name);
        }
        
        if ($scope & SC_COOKIE && isset($cookie)) {
            $result = self::getCookie($name);
        }

        if ($scope & SC_SERVER && isset($server)) {
            $result = self::getServer($name);
        }

        return $result;
    }

    /**
     * Возвращает true если используется защищенный протокол HTTPS
     *
     * @access public
     * @return boolean
     */
    public function isSecure() {
        $temp = self::getServer('HTTPS');
        return !empty($temp);
    }

    /**
     * Метод возвращает протокол, который был использован для передачи данных.
     * Возможные варианты: GET, HEAD, POST, PUT.
     *
     * @access public
     * @return boolean
     */
    public function getMethod() {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * Метод получения переменной из суперглобального массива _GET
     *
     * @access private
     * @return string|null
     */
    private static function getGet($name)
    {
        return ( isset($_GET[$name]) ) ? $_GET[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _POST
     *
     * @access private
     * @return string|null
     */
    private static function getPost($name)
    {
        return ( isset($_POST[$name]) ) ? $_POST[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _COOKIE
     *
     * @access private
     * @return string|null
     */
    private static function getCookie($name)
    {
        return ( isset($_COOKIE[$name]) ) ? $_COOKIE[$name] : null;
    }


    /**
     * Метод получения переменной из суперглобального массива _SERVER
     *
     * @access private
     * @return string|null
     */
    private static function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }

}
?>