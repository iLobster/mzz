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
 * @version 0.1.2
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
     * Возвращает сгенерированный полный URL
     *
     * @return string
     */
    public function get()
    {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();

        $address = $request->getUrl();
        if (empty($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        $params = '';
        $this->params  = $this->getParams();
        if(!empty($this->params)) {
            if(!empty($this->section)) {
                $params = '/';
            }

            $params .= implode('/', $this->params);

            if(!empty($this->action)) {
                $params .= '/';
            }
        } else {
            if (!empty($this->section) && !empty($this->action)) {
                $params = '/';
            }
        }
        $url = $this->section . $params . $this->action;
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
     * @param string $value
     */
    public function addParam($value)
    {
        $this->params[] = $value;
    }

    /**
     * Выборка параметра
     *
     */
    public function getParams()
    {
        foreach($this->params as $key => $param) {
            if(empty($this->params[$key])) {
                unset($this->params[$key]);
            }
        }
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
}

?>