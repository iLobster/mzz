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
 * @version 0.1
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
        /* @todo ����������� ���� ������ */
        $path = trim($path, '/');

        $params = array('section' => 'page', 'action' => 'view');

        foreach (array_reverse($this->routes) as $route) {
            if ($parts = $route->match($path)) {
                $params = $parts;
                $this->current = $route;
                break;
            }
        }

        $this->request->setParams($params);
    }

}

?>