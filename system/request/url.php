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
     * Params
     *
     * @var array
     */
    protected $params = array();

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
    public function __construct()
    {
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

        $address = $request->getUrl();
        $this->params  = array_map('urlencode', $this->getParams());

        if (is_null($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        if ($this->route instanceof iRoute) {
            $params = $this->params;
            if (empty($params['section'])) {
                $params['section'] = urlencode($this->section);
            }
            if (empty($params['action'])) {
                $params['action'] = urlencode($this->action);
            }
            $url = $this->route->assemble($params);
            $this->deleteRoute();
        } else {
            $params = '';
            if(!empty($this->params)) {
                if(!empty($this->section)) {
                    $params = '/';
                }

                $params .= implode('/', $this->params);

                if(!empty($this->action)) {
                    $params .= '/';
                }
            } else {
                if (!empty($this->section) && !empty($this->action)) {
                    $params = '/';
                }
            }
            $url = urlencode($this->section) . $params . urlencode($this->action);
        }

        if (sizeof($this->getParams)) {
            $url .= '?';
            foreach ($this->getParams as $key => $val) {
                $url .= urlencode($key) . '=' . urlencode($val) . '&amp;';
            }
            $url = substr($url, 0, -5);
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
        foreach($this->params as $key => $param) {
            if(empty($this->params[$key])) {
                unset($this->params[$key]);
            }
        }
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
    public function setRoute(iRoute $route)
    {
        $this->route = $route;
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