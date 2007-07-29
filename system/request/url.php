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
 * @version 0.2
 */
class url
{
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
        if ($route){
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

        $params = $this->params;
        if (empty($params['section'])) {
            $params['section'] = $this->getCurrentSection();
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
     * ���������� ���������
     *
     * @param string $name
     * @param string $value
     * @param boolean $get ���� true, �� �������� ����� �������� ��� GET (?param=value&param2=value2...)
     */
    public function add($name, $value, $get = false)
    {
        if (!$get) {
            $this->params[$name] = $value;
        } else {
            $this->getParams[$name] = $value;
        }
    }

    /**
     * ��������� ����� ������
     *
     * @param string $value
     */
    public function setSection($value)
    {
        $this->add('section', $value);
    }

    /**
     * ��������� ����� ��������
     *
     * @param string $value
     */
    public function setAction($value)
    {
        $this->add('action', $value);
    }

    /**
     * ���������� ��� ������������� �� GET ���������
     *
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * �������� ������� section �� Request
     *
     * @return string
     */
    protected function getCurrentSection()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getRequest()->getSection();
    }

    /**
     * ������������� ������� ����, �� �������� ����� ������ url
     *
     * @param iRoute $route
     */
    public function setRoute($route)
    {
        $toolkit = systemToolkit::getInstance();
        $this->route = $toolkit->getRouter()->getRoute($route);
    }

    /**
     * ������� ������������� ����
     *
     * @deprecated ?
     * @see get()
     */
    public function deleteRoute()
    {
        $this->route = null;
    }
}

?>