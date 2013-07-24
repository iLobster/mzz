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
     * Включать в генерируемый URL адрес сайта
     *
     * @var boolean
     */
    protected $withAddress = false;

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
     * @param bool $encodeUrl - выполнять urlencode или нет
     * @return string
     */
    public function get($encodeUrl = false)
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        if (!($this->route instanceof iRoute)) {
            $error = "Url error. Route is not specified.";
            throw new mzzRuntimeException($error);
        }

        $address = $this->withAddress ? $request->getUrl() : SITE_PATH;
        $this->params  = $this->getParams();

        if ($lang_id = $request->getInteger('lang_id', SC_GET)) {
            $this->getParams['lang_id'] = $lang_id;
        }

        $params = $this->params;

        if (empty($params['module'])) {
            $params['module'] = $request->getModule();
        }

        $path = $this->route->assemble($params, $encodeUrl);
        if ($encodeUrl) {
            $path = str_replace('%2F', '/', urlencode($path));
        }

        if (sizeof($this->getParams)) {
            $path .= '?' . http_build_query($this->getParams);
        }

        $url = $address . (!empty($path) ? '/' . $path : '');
        if (!empty($this->anchor)) {
            $url .= (empty($path) ? '/' : '') . '#' . $this->anchor;
        }
        return $url;
    }

    /**
     * Предотвращает добавление полного адреса к генерируемому URL
     */
    public function disableAddress()
    {
        $this->withAddress = false;
    }
    
    /**
     * Включает добавление полного адреса к генерируемому URL
     */
    public function enableAddress()
    {
        $this->withAddress = true;
    }

    /**
     * Добавление параметра
     * Т.к. http_build_query кодирует и имена, массивы в GET-параметрах не поддерживаются
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
            $this->getParams[$name] = $value;
        }
    }

    /**
     * Устанавливает модуль
     *
     * @param string $name
     */
    public function setModule($name)
    {
        $this->add('module', $name);
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
     * Устанавливает текущий роут, по которому будет собран url
     *
     * @param string $route
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