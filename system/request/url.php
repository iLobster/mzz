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

/**
 * url: ����� ��� ��������� URL
 *
 * @package system
 * @subpackage request
 * @version 0.1.3
 */
class url
{
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
     * ���������
     *
     * @var array
     */
    protected $params = array();

    /**
     * GET-���������
     *
     * @var array
     */
    private $getParams = array();

    /**
     * Route
     *
     * @var iRoute|null
     */
    protected $route = null;

    /**
     * �����������.
     *
     */
    public function __construct($route = null)
    {
        if($route){
            $this->setRoute($route);
        }
    }

    /**
     * ���������� ��������������� ������ URL
     *
     * @return string
     */
    public function get()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        if (!($this->route instanceof iRoute)) {
            $error = "Url error. Route is not specified.";
            throw new mzzRuntimeException($error);
        }

        $address = $request->getUrl();
        $this->params  = $this->getParams();

        if (is_null($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        $params = $this->params;
        if (empty($params['section'])) {
            $params['section'] = $this->section;
        }
        if (!empty($this->action)) {
            $params['action'] = $this->action;
        }
        $url = $this->route->assemble($params);

        if (sizeof($this->getParams)) {
            $url .= '?';
            foreach ($this->getParams as $key => $val) {
                $url .= $key . '=' . $val . '&';
            }
            $url = substr($url, 0, -1);
        }

        return $address . (!empty($url) ? '/' . $url : '');
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
     * ���������� ���������
     *
     * @param string $name
     * @param string $value
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * ��������� ���������� GET
     *
     * @param string $name
     * @param string $value
     */
    public function setGetParam($name, $value)
    {
        $this->getParams[$name] = $value;
    }

    /**
     * ������� ����������
     *
     */
    public function getParams()
    {
        //foreach($this->params as $key => $param) {
        //if (empty($this->params[$key])) {
        //unset($this->params[$key]);
        //}
        //}
        return $this->params;
    }

    /**
     * �������� ������� section �� Request
     *
     * @return string
     */
    private function getCurrentSection()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getRequest()->getSection();
    }

    /**
     * ������������� ������� route ��� ������ url
     *
     * @param iRoute $route
     */
    public function setRoute($route)
    {
        $toolkit = systemToolkit::getInstance();
        $this->route = $toolkit->getRouter()->getRoute($route);
    }

    /**
     * ������� ������������� route ��� ������ url
     *
     * @see get()
     */
    public function deleteRoute()
    {
        $this->route = null;
    }
}

?>