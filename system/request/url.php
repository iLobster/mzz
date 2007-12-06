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
 * url: класс для генерации URL
 *
 * @package system
 * @subpackage request
 * @version 0.2
 */
class url
{
    /**
     * Параметры
     *
     * @var array
     */
    protected $params = array();

    /**
     * GET-параметры
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
     * HTML якорь
     *
     * @var string
     */
    protected $anchor;

    /**
     * Конструктор.
     *
     */
    public function __construct($route = null)
    {
        if ($route){
            $this->setRoute($route);
        }
    }

    /**
     * Возвращает сгенерированный полный URL
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

        $path = $this->route->assemble($params);

        if (sizeof($this->getParams)) {
            $path .= '?';
            foreach ($this->getParams as $key => $val) {
                $path .= $key . '=' . $val . '&';
            }
            $path = substr($path, 0, -1);
        }

        $url = $address . (!empty($path) ? '/' . $path : '');
        if (!empty($this->anchor)) {
            $url .= (empty($path) ? '/' : '') . '#' . $this->anchor;
        }
        return $url;
    }

    /**
     * Добавление параметра
     *
     * @param string $name
     * @param string $value
     * @param boolean $get если true, то параметр будет добавлен как GET (?param=value&param2=value2...)
     */
    public function add($name, $value, $get = false)
    {
        if ($name == '#') {
            $this->anchor = $value;
            return;
        }

        if (!$get) {
            $this->params[$name] = $value;
        } else {
            $this->getParams[$name] = rawurlencode($value);
        }
    }

    /**
     * Установка имени секции
     *
     * @param string $value
     */
    public function setSection($value)
    {
        $this->add('section', $value);
    }

    /**
     * Установка имени действия
     *
     * @param string $value
     */
    public function setAction($value)
    {
        $this->add('action', $value);
    }

    /**
     * Возвращает все установленные не GET параметры
     *
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Получает текущий section из Request
     *
     * @return string
     */
    protected function getCurrentSection()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getRequest()->getSection();
    }

    /**
     * Устанавливает текущий роут, по которому будет собран url
     *
     * @param iRoute $route
     */
    public function setRoute($route)
    {
        $toolkit = systemToolkit::getInstance();
        $this->route = $toolkit->getRouter()->getRoute($route);
    }

    /**
     * Убирает установленный роут
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