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


    /**#@+
    * @access protected
    * @var array
    */
    /**
     * POST-данные
     */
    protected $post_vars;

    /**
     * GET-данные
     */
    protected $get_vars;

    /**
     * Cookie
     */
    protected $cookie_vars;

    protected $section;
    protected $action;
    protected $params = array();
    /**#@-*/

    /**
     * Singleton
     *
     * @var object
     * @access private
     */
    private static $instance;

    /**
     * Конструктор.
     *
     * @access public
     */
    public function __construct()
    {
        $rewrite = Rewrite::getInstance();
        $this->post_vars = $_POST;
        $this->get_vars = $_GET;
        $this->cookie_vars = $_COOKIE;
        requestParser::parse($this->get('path'));

        $rewrite->getRules($this->getSection());
        requestParser::parse($rewrite->process($this->get('path')));
    }

    /**
     * Singleton method
     *
     * @access public
     * @return object
     */
    public function getInstance() {
        $classname = __CLASS__;
        if(!(self::$instance instanceof $classname)) {
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    /**
     * Метод получения переменной из суперглобального массива
     *
     * @access public
     * @param string $name имя переменной
     * @param boolean $scope бинарное число, определяющее в каких массивах искать переменную
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
     *
     * @access public
     * @return string|null возможные варианты: GET, HEAD, POST, PUT
     */
    public function getMethod() {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * Метод получения переменной из суперглобального массива _GET
     *
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private function getGet($name)
    {
        return ( isset($this->get_vars[$name]) ) ? $this->get_vars[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _POST
     *
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private function getPost($name)
    {
        return ( isset($this->post_vars[$name]) ) ? $this->post_vars[$name] : null;
    }

    /**
     * Метод получения переменной из суперглобального массива _COOKIE
     *
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private function getCookie($name)
    {
        return ( isset($this->cookie_vars[$name]) ) ? $this->cookie_vars[$name] : null;
    }


    /**
     * Метод получения переменной из суперглобального массива _SERVER
     *
     * @access private
     * @param string $name имя переменной
     * @return string|null
     */
    private function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }

    public function setSection($value)
    {
        $this->section = $value;
    }

    public function setAction($value)
    {
        $this->action = $value;
    }

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function setParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * Получение значения из результата разборки
     *
     * @param string $field
     * @return string|array|null
     * @access public
     */
    public function getSection()
    {
        return $this->section;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getParam($name)
    {
        return $this->params[$name];
    }
}

?>