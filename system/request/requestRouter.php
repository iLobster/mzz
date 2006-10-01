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
    protected $router;

    /**
     * ��������� �������, � ������� ������ PATH
     *
     * @var array
     */
    protected $current;

    /**
     * �����������
     *
     */
    public function __construct()
    {
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
     * @param iRoute $path �������
     */
    public function getCurrentRoute()
    {

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
            if ($params = $route->match($path)) {
                $controller = $params['controller'];
                $action     = $params['action'];
                break;
            }
        }

        //return array($controller, $action, $params);
    }

}

?>