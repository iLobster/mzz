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
        $protocol = $request->isSecure() ? 'https' : 'http';
        $port = $request->get('SERVER_PORT', 'mixed', SC_SERVER);
        $port = ($port == '80') ? '' : ':' . $port;

        $address = $protocol . '://' . $request->get('HTTP_HOST', 'mixed', SC_SERVER) . $port . SITE_PATH;

        if (empty($this->section)) {
            $this->setSection($this->getCurrentSection());
        }

        $params = '';
        $this->params  = $this->getParams();
        //echo"<pre><b>this->params</b> ";var_dump($this->params); echo"</pre>";
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
        $request_uri = $this->section . $params . $this->action;
        //echo"<pre>";print_r("$request_uri request_uri = $this->section . $params . $this->action;"); echo"</pre>";
        return $address . (!empty($request_uri) ? '/' . $request_uri : '');
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
        return $toolkit->getRequest()->get('section', 'mixed', SC_PATH);
    }
}

?>