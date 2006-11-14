<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id$
*/

fileLoader::load('request/iRequest');

/**
 * httpRequest: ����� ��� ������ � ���������������� ���������.
 * ������ � httpRequest ����� �������� ����� Toolkit.
 *
 * Examples:
 * <code>
 * $httprequest->get('var', SC_GET | SC_COOKIE);
 * $httprequest->get('var2');
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.7
 */

define('SC_GET', 1);
define('SC_POST', 2);
define('SC_REQUEST', SC_GET | SC_POST);
define('SC_COOKIE', 4);
define('SC_SERVER', 8);
define('SC_PATH', 16);

class httpRequest implements iRequest
{
    /**#@+
    * @var array
    */
    /**
     * POST-������
     */
    protected $postVars;

    /**
     * GET-������
     */
    protected $getVars;

    /**
     * Cookie
     */
    protected $cookieVars;

    /**
     * �������� ��� ���������� �������� ����������� ����������
     *
     */
    protected $saved;

    /**
     * ���������
     *
     */
    protected $params = null;
    /**#@-*/

    /**
     * ������
     *
     * @var string
     */
    protected $section;

    /**
     * ��������
     *
     * @var string
     */
    protected $action;

    /**
     * �����������.
     *
     */
    public function __construct()
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->params = new arrayDataspace();
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
     * @param string  $name  ��� ����������
     * @param string  $type  ���, � ������� ����� ������������� ��������
     * @param integer $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $type = null, $scope = SC_REQUEST)
    {
        $result = null;

        $done = false;
        if (!$done && $scope & SC_SERVER && !is_null($result = $this->getServer($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_COOKIE && !is_null($result = $this->cookieVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_POST && !is_null($result = $this->postVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_GET && !is_null($result = $this->getVars->get($name))) {
            $done = true;
        }

        if (!$done && $scope & SC_PATH && !is_null($result = $this->params->get($name))) {
            $done = true;
        }

        if ($this->isAjax()) {
            $result = $this->decodeUTF8($result);
        }

        if (is_null($result) || (empty($type) || $type == 'mixed')) {
            return $result;
        } else {
            return $this->convertToType($result, $type);
        }
    }

    /**
     * ��������������� �������� ���������� $result � ���� $type
     * ���� $result ������, �� �� ���� ����������� ������ ������� �
     * ���������� �������������� ���������� ������ � ���� ���������
     *
     * @param mixed $result �������� ���������� �� URI
     * @param string $type ���, � ������� ����� ������������� ��������
     * @return mixed
     */
    public function convertToType($result, $type)
    {
        $validTypes = array('array', 'integer', 'boolean', 'string');
        if (gettype($result) == 'array' && $type != 'array') {
            $result = array_shift($result);
        }

        if (gettype($result) != $type && in_array($type, $validTypes)) {
            settype($result, $type);
        }
        return $result;
    }

    /**
     * ���������� true ���� ������������ ���������� �������� HTTPS
     *
     * @return boolean
     */
    public function isSecure()
    {
        $temp = $this->getServer('HTTPS');
        return ($temp === 'on');
    }

    /**
     * ���������� true ���� ������������ AJAX
     *
     * @return boolean
     */
    public function isAjax()
    {
        return isset($_REQUEST['ajax']);
    }

    /**
     * ����� ���������� ��������, ������� ��� ����������� ��� �������� ������.
     *
     * @return string|null ��������� ��������: GET, HEAD, POST, PUT
     */
    public function getMethod()
    {
        return $this->getServer('REQUEST_METHOD');
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
     * ���������� ������� ������
     *
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * ������������� ������� ������
     *
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * ���������� ������� ��������
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * ������������� ������� ��������
     *
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * ��������� ������������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function setParam($name, $value)
    {
        $this->params->set($name, $value);
    }

    /**
     * ��������� ������� ����������. ������������ ��������� ����� ����������
     *
     * @param array $params
     */
    public function setParams(Array $params)
    {
        $this->params = new arrayDataspace($params);
    }

    /**
     * ������� ������� ����������
     *
     * @return array
     */
    public function & getParams()
    {
        return $this->params->export();
    }

    /**
    * ��������� �������� ����, ��������� ����
    *
    * @return string URL
    */
    public function getUrl()
    {
        $protocol = $this->isSecure() ? 'https' : 'http';
        $port = $this->get('SERVER_PORT', 'mixed', SC_SERVER);
        $port = ($port == '80') ? '' : ':' . $port;

        return $protocol . '://' . $this->get('HTTP_HOST', 'mixed', SC_SERVER) . $port . SITE_PATH;
    }

    /**
    * ��������� �������� ���� c �����
    *
    * @return string URL
    */
    public function getRequestUrl()
    {
        return $this->getUrl() . '/' . $this->getPath();
    }

    /**
    * ��������� �������� ����
    *
    * @return string PATH
    */
    public function getPath()
    {
        return trim(preg_replace('/\/{2,}/', '/', $this->get('path', 'mixed', SC_REQUEST)), '/');
    }

    /**
     * ���������� �������� ��������� ����������
     *
     */
    public function save()
    {
        $this->saved['params'] = $this->params->export();
        $this->saved['section'] = $this->getSection();
        $this->saved['action'] = $this->getAction();
    }

    /**
     * �������������� ������������ ����� ���������
     *
     */
    public function restore()
    {
        if (!empty($this->saved)) {
            $this->params->import($this->saved['params']);
            $this->setSection($this->saved['section']);
            $this->setAction($this->saved['action']);
            $this->saved = array();
            return true;
        }
        return false;
    }

    public function decodeUTF8($value)
    {
        if (function_exists('iconv')) {
            $value = iconv("UTF-8", 'windows-1251//TRANSLIT', $value);
        } elseif (function_exists('mb_convert_encoding')) {
            $value = mb_convert_encoding($value, 'windows-1251', "UTF-8");
        } else {
            throw new mzzRuntimeException("The incoming data could not be converted from UTF-8");
        }

        return $value;
    }

}

?>