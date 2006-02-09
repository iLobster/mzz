<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

/**
 * url: класс для генерации URL
 *
 * @package system
 * @subpackage request
 * @version 0.1
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


    /**
     * Конструктор.
     *
     */
    public function __construct()
    {
    }

    /**
     * Возвращает сгенерированный URL
     *
     * @return string
     */
    public function get()
    {
        if(empty($this->section)) {
            $this->setSection($this->getCurrentSection());
        }
        return '/' . $this->section . '/' . implode('/', $this->params) . '/' . $this->action;
    }

    /**
     * Возвращает сгенерированный полный URL
     *
     * @return string
     */
    public function getFull()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        $protocol = $request->isSecure() ? 'https' : 'http';
        $address = $protocol . '://' . $request->get('HTTP_HOST', SC_SERVER);

        if(empty($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        $params = "/";
        if(empty($this->params) == false) {
            $params .= implode('/', $this->params) . '/';
        }
        return $address . '/' . $this->section . $params . $this->action;
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
     * @param string $value
     */
    public function addParam($value)
    {
        $this->params[] = $value;
    }

    /**
     * Получает текущий section из Request
     *
     */
    private function getCurrentSection()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        return $request->getSection();
    }
}

?>