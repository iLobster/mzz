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
 * requestRouter: маршрутизатор.
 * ѕри первом совпадении PATH с правилом производит его декомпозицию согласно правилу, определ€€
 * какое действие у какого контроллера будет выполнено.
 * ѕараметры, если они были указаны, будут переданы объекту httpRequest.
 *
 * ѕримеры:
 * <code>
 * new requestRouter('default', new requestRoute(':controller/:id/:action'));
 * </code>
 *
 * @package system
 * @subpackage request
 * @version 0.1.1
 */
class requestRouter
{
    /**
     * ѕравила
     *
     * @var array
     */
    protected $routes = array();

    /**
     * ѕоследнее правило, с которым совпал PATH
     *
     * @var array
     */
    protected $current;

    protected $debug = false;
    /**
     *  онструктор
     *
     * @param iRequest $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * ƒобавл€ет новое правило.
     *
     * @param string $name им€
     * @param iRoute $route правило
     */
    public function addRoute($name, iRoute $route)
    {
        if (isset($this->routes[$name])) {
            throw new mzzRuntimeException('Route с именем ' . $name . ' уже добавлен');
        }
        $this->routes[$name] = $route;
    }

    /**
     * ¬озвращает правило с именем $name
     *
     * @param string $name им€
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
     * ¬озвращает последнее правило, с которым совпал PATH
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
     * «апуск проверки совпадени€ $path с шаблонами и
     * его декомпозици€ согласно соответствующему правилу.
     * ≈сли ни один шаблон не совпадет с $path, будут использованы
     * контроллер и действие установленные по умолчанию
     *
     * @param string $path
     */
    public function route($path)
    {
        foreach (array_reverse($this->routes) as $route) {
            if ($parts = $route->match($path, $this->debug)) {
                $params = $parts;
                $this->current = $route;
                break;
            }
        }

        if (!isset($params)) {
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

    public function enableDebug()
    {
        $this->debug = true;
    }
}

?>