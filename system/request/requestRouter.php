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
 * @version 0.1
 */
class requestRouter
{
    /**
     * ѕравила
     *
     * @var array
     */
    protected $router;

    /**
     * ѕоследнее правило, с которым совпал PATH
     *
     * @var array
     */
    protected $current;

    /**
     *  онструктор
     *
     */
    public function __construct()
    {
    }

    /**
     * ƒобавл€ет новое правило.
     *
     * @param string $name им€
     * @param iRoute $route правило
     */
    public function addRoute($name, iRoute $route)
    {
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
     * @param iRoute $path правило
     */
    public function getCurrentRoute()
    {

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