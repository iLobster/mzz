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
 * HttpRequest: ����� ��� ������ � ���������������� ���������
 * Examples:
 * <code>
 * httprequest::get('var', SC_GET | SC_COOKIE);
 * httprequest::get('var2');
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.5
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);
define('SC_PATH', 16);

class httpRequest
{


    /**#@+
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

    /**
     * Params
     *
     */
    protected $params = array();
    /**#@-*/

    /**
     * Section
     *
     * @var string
     */
    protected $section;

    /**
     * Action
     *
     * @var string
     */
    protected $action;



    /**
     * �����������.
     *
     */
    public function __construct($requestParser)
    {
        $this->post_vars = $_POST;
        $this->get_vars = $_GET;
        $this->cookie_vars = $_COOKIE;
        $this->requestParser = $requestParser;
        $this->parse($this->get('path'));
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
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

        if ($scope & SC_PATH) {
            if ( ($result = self::getParam($name)) != null )
            return $result;
        }

        return $result;
    }

    public function parse($path)
    {
        $this->requestParser->parse($this, $path);
    }
    /**
     * ���������� true ���� ������������ ���������� �������� HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        $temp = self::getServer('HTTPS');
        return !empty($temp);
    }

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     *
     * @return string|null ��������� ��������: GET, HEAD, POST, PUT
     */
    public function getMethod()
    {
        return self::getServer('REQUEST_METHOD');
    }

    /**
     * ����� ��������� ���������� �� ���������������� ������� _GET
     *
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
     * @param string $name ��� ����������
     * @return string|null
     */
    private function getServer($name)
    {
        return ( isset($_SERVER[$name]) ) ? $_SERVER[$name] : null;
    }

    /**
     * ��������� section
     *
     * @param string $value
     */
    public function setSection($value)
    {
        $this->section = $value;
    }

    /**
     * ��������� action
     *
     * @param string $value
     */
    public function setAction($value)
    {
        $this->action = $value;
    }

    /**
     * ��������� ������������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * ��������� ������� ����������
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * ���������� section
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * ���������� action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * ���������� ������������ ���������
     *
     * @param string $name
     * @return string
     */
    public function getParam($name)
    {
        return (isset($this->params[$name])) ? $this->params[$name] : null;
    }

    /**
     * Get all params from url
     *
     * @deprecated use getParam
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
}

?>