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
 * @version 0.6.1
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
     * �������� ��� ���������� �������� ���������� ����������
     *
     */
    protected $savedParams;

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
     * ������ ��� ���������� �������� section � action ����� save() � restore()
     *
     * @var array
     */
    protected $savedSectionAction = array();

    /**
     * �����������.
     *
     * @param object $requestParser
     */
    public function __construct($requestParser)
    {
        $this->postVars = new arrayDataspace($_POST);
        $this->getVars = new arrayDataspace($_GET);
        $this->cookieVars = new arrayDataspace($_COOKIE);
        $this->requestParser = $requestParser;
        $this->import($this->get('path'));
        $this->savedParams = new arrayDataspace();
    }

    /**
     * ����� ��������� ���������� �� ���������������� �������
     *
     * @param string  $name  ��� ����������
     * @param integer $scope �������� �����, ������������ � ����� �������� ������ ����������
     * @return string|null
     */
    public function get($name, $scope = SC_REQUEST)
    {
        $result = null;

        if ($scope & SC_SERVER && !is_null($result = $this->getServer($name))) {
            return $result;
        }

        if ($scope & SC_COOKIE && !is_null($result = $this->cookieVars->get($name))) {
            return $result;
        }

        if ($scope & SC_POST && !is_null($result = $this->postVars->get($name))) {
            return $result;
        }

        if ($scope & SC_GET && !is_null($result = $this->getVars->get($name))) {
            return $result;
        }

        if ($scope & SC_PATH && !is_null($result = $this->params->get($name))) {
            return $result;
        }

        return $result;
    }

    /**
     * ������ ������ � section, action � �����������
     *
     * @param string $path
     */
    public function import($path)
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
        $temp = $this->getServer('HTTPS');
        return ($temp === 'on');
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
        if (($this->params instanceof iDataspace) == false) {
            $this->setParams(array());
        }
        $this->params->set($name, $value);
    }

    /**
     * ��������� ������� ����������
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
    public function getParams()
    {
        return $this->params->export();
    }

    /**
    * ��������� �������� ����
    * ���� ���������� ���� path, �������� QUERY_STRING
    * @return string ���
    */
    public function getUrl()
    {
        return $this->getVars->get('path');
    }

    /**
     * ���������� �������� ��������� ����������<br>
     * (SC_PATH)
     *
     */
    public function save()
    {
        $this->savedParams = clone $this->params;
        $this->savedSectionAction['action'] = $this->action;
        $this->savedSectionAction['section'] = $this->section;
    }

    /**
     * �������������� ����������� ����� ���������
     *
     */
    public function restore()
    {
        $this->params = clone $this->savedParams;
        $this->section = $this->savedSectionAction['section'];
        $this->action = $this->savedSectionAction['action'];
    }
}

?>