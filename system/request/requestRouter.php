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
 * requestRouter: �������������.
 * ��� ������ ���������� PATH � �������� ���������� ��� ������������ �������� �������, ���������
 * ����� �������� � ������ ����������� ����� ���������.
 * ���������, ���� ��� ���� �������, ����� �������� ������� httpRequest.
 *
 * �������:
 * <code>
 * new requestRouter('default', new requestRoute(':controller/:id/:action'));
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.1.2
 */
class requestRouter
{
    /**
     * �������
     *
     * @var array
     */
    protected $routes = array();

    /**
     * ��������� �������, � ������� ������ PATH
     *
     * @var array
     */
    protected $current;

    /**
     * ����� ���������� ����������
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * �����������
     *
     * @param iRequest $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * ��������� ����� �������.
     *
     * @param string $name ���
     * @param iRoute $route �������
     */
    public function addRoute($name, iRoute $route)
    {
        if (isset($this->routes[$name])) {
            throw new mzzRuntimeException('Route � ������ ' . $name . ' ��� ��������');
        }
        $route->setName($name);
        $this->routes[$name] = $route;
    }

    /**
     * ���������� ������� � ������ $name
     *
     * @param string $name ���
     */
    public function getRoute($name)
    {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        } else {
            throw new mzzRuntimeException("Cannot find route with name '" . $name . "'");
        }
    }

    /**
     * ���������� ��������� �������, � ������� ������ PATH
     *
     * @return iRoute
     */
    public function getCurrentRoute()
    {
        if (!empty($this->current)) {
            return $this->current;
        } else {
            throw new mzzRuntimeException("Cannot find current route");
        }
    }

    /**
     * ������ �������� ���������� $path � ��������� �
     * ��� ������������ �������� ���������������� �������.
     * ���� �� ���� ������ �� �������� � $path, ����� ������������
     * ���������� � �������� ������������� �� ���������
     *
     * @param string $path
     */
    public function route($path)
    {
        foreach (array_reverse($this->routes) as $route) {
            if ($params = $route->match($path, $this->debug)) {
                $this->current = $route;
                break;
            }
        }

        if (!is_array($params)) {
            fileLoader::load('exceptions/mzzRouteException');
            throw new mzzRouteException(404);
        }

        if (isset($params['section'])) {
            $this->request->setSection($params['section']);
            unset($params['section']);
        }
        if (isset($params['action'])) {
            $this->request->setAction($params['action']);
            unset($params['action']);
        }

        $this->request->setParams($params);
    }

    /**
     * ��������� ����������� ���������� ����������
     *
     */
    public function enableDebug()
    {
        $this->debug = true;
    }
}

?>