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
 * @version 0.1.3
 */
class url
{
    /**
     * Секция
     *
     * @var string
     */
    protected $section;

    /**
     * Действие
     *
     * @var string
     */
    protected $action;

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
     * Конструктор.
     *
     */
    public function __construct($route = null)
    {
        if($route){
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

        if (is_null($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        $params = $this->params;
        if (empty($params['section'])) {
            $params['section'] = $this->section;
        }
        if (!empty($this->action)) {
            $params['action'] = $this->action;
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
     * Установка section
     *
     * @param string $value
     */
    public function setSection($value)
    {
        $this->section = $value;
    }

    /**
     * Установка action
     *
     * @param string $value
     */
    public function setAction($value)
    {
        $this->action = $value;
    }

    /**
     * Добавление параметра
     *
     * @param string $name
     * @param string $value
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Установка переменных GET
     *
     * @param string $name
     * @param string $value
     */
    public function setGetParam($name, $value)
    {
        $this->getParams[$name] = $value;
    }

    /**
     * Выборка параметров
     *
     */
    public function getParams()
    {
        //foreach($this->params as $key => $param) {
        //if (empty($this->params[$key])) {
        //unset($this->params[$key]);
        //}
        //}
        return $this->params;
    }

    /**
     * Получает текущий section из Request
     *
     * @return string
     */
    private function getCurrentSection()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getRequest()->getSection();
    }

    /**
     * Устанавливает текущий route для сборки url
     *
     * @param iRoute $route
     */
    public function setRoute($route)
    {
        $toolkit = systemToolkit::getInstance();
        $this->route = $toolkit->getRouter()->getRoute($route);
    }

    /**
     * Убирает установленный route для сборки url
     *
     * @see get()
     */
    public function deleteRoute()
    {
        $this->route = null;
    }
}

?>