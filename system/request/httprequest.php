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


    /**#@+
    * @access protected
    * @var array
    */
    /**
     * POST-������
     */
    protected $post_vars;

    /**
     * GET-������
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
     * �����������.
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
     *
     * @access public
     * @return string|null ��������� ��������: GET, HEAD, POST, PUT
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
    private function getGet($name)
    {
        return ( isset($this->get_vars[$name]) ) ? $this->get_vars[$name] : null;
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _POST
     *
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private function getPost($name)
    {
        return ( isset($this->post_vars[$name]) ) ? $this->post_vars[$name] : null;
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _COOKIE
     *
     * @access private
     * @param string $name ��� ����������
     * @return string|null
     */
    private function getCookie($name)
    {
        return ( isset($this->cookie_vars[$name]) ) ? $this->cookie_vars[$name] : null;
    }


    /**
     * ����� ��������� ���������� �� ���������������� ������� _SERVER
     *
     * @access private
     * @param string $name ��� ����������
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
     * ��������� �������� �� ���������� ��������
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