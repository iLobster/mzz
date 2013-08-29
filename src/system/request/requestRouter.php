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
 * При первом совпадении PATH с правилом производит его декомпозицию согласно правилу, определяя
 * какое действие у какого контроллера будет выполнено.
 * Параметры, если они были указаны, будут переданы объекту httpRequest.
 *
 * Примеры:
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
     * Правила
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Последнее правило, с которым совпал PATH
     *
     * @var array
     */
    protected $current;

    /**
     * Вывод отладочной информации
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Объект httpRequest, содержащий в себе параметры запроса
     *
     * @var httpRequest
     */
    private $request;

    /**
     * Если true, то учитывается информация о языке
     *
     * @var boolean
     */
    protected $withLang = false;

    /**
     * Имя дефолтного роута
     *
     * @var string
     */
    protected $defaultName = 'default';

    protected $prepend;

    /**
     * Конструктор
     *
     * @param iRequest $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Добавляет новое правило.
     *
     * @param string $name имя
     * @param iRoute $route правило
     */
    public function addRoute($name, iRoute $route)
    {
        if (isset($this->routes[$name])) {
            throw new mzzRuntimeException('The route ' . $name . ' already added');
        }
        $route->setName($name);
        $this->routes[$name] = $route;
        if ($this->withLang) {
            $route->enableLang();
        }

        return $this;
    }

    /**
     * Возвращает правило с именем $name
     *
     * @param string $name имя
     */
    public function getRoute($name)
    {
        if (isset($this->routes[$name])) {
            return $this->routes[$name];
        } else {
            throw new mzzRuntimeException("Cannot find the route with the name '" . $name . "'");
        }
    }

    /**
     * Возвращает дефолтный роут
     *
     * @return requestRoute
     */
    public function getDefaultRoute()
    {
        return $this->getRoute($this->defaultName);
    }

    /**
     * Устанавливает имя дефолтного роута
     *
     * @param string $name имя
     */
    public function setDefaultRoute($name)
    {
        if (isset($this->routes[$name])) {
            $this->defaultName = $name;
        } else {
            throw new mzzRuntimeException("Cannot find the route with the name '" . $name . "'");
        }
    }

    /**
     * Возвращает список всех правил
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Возвращает последнее правило, с которым совпал PATH
     *
     * @return iRoute
     */
    public function getCurrentRoute()
    {
        if (!empty($this->current)) {
            return $this->current;
        } else {
            throw new mzzNoRouteException("Cannot find current route");
        }
    }

    /**
     * Запуск проверки совпадения $path с шаблонами и
     * его декомпозиция согласно соответствующему правилу.
     * Если ни один шаблон не совпадет с $path, будут использованы
     * контроллер и действие установленные по умолчанию
     *
     * @param string $path
     */
    public function route($path)
    {
        foreach ($this->routes as $route) {
            if ($this->prepend) {
                $route->prepend($this->prepend);
            }
            if ($params = $route->match($path, $this->debug)) {
                $this->current = $route;
                break;
            }
        }

        //@todo: не понимаю, что это. Либо давайте удалим, либо напишем, что ни один роут не выстрельнул
        if (!isset($params) || !is_array($params)) {
            fileLoader::load('exceptions/mzzRouteException');
            throw new mzzRouteException(404);
        }

        if (isset($params['module'])) {
            $this->request->setModule($params['module']);
            unset($params['module']);
        }

        if (isset($params['action'])) {
            $this->request->setAction($params['action']);
            unset($params['action']);
        }

        $this->request->setParams($params);
    }

    /**
     * Включение учета языка
     *
     */
    public function enableLang()
    {
        $this->withLang = true;
    }

    /**
     * Adds a prepend route to all routes
     *
     * @param iRoute $prepend
     */
    public function prepend(iRoute $route)
    {
        $this->prepend = $route;
    }

    /**
     * Включение отображения отладочной информации
     *
     */
    public function enableDebug()
    {
        $this->debug = true;
    }
}

?>