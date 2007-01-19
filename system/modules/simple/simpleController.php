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
 * simpleController: реализация общих методов у контроллеров
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
abstract class simpleController
{
    /**
     * Объект Toolkit
     *
     * @var object
     */
    protected $toolkit;

    /**
     * Объект Request
     *
     * @var iRequest
     */
    protected $request;

    /**
     * Объект шаблонного движка
     *
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * Конструктор
     *
     */
    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        $this->response = $this->toolkit->getResponse();

        if ($this->toolkit->getRegistry()->get('isJip') && $this->request->isAjax()) {
            $this->smarty->setActiveXmlTemplate('main.xml.tpl');
            $this->response->setHeader('Content-Type', 'text/xml');
        }
    }

    /**
     * Возвращает объект отображения
     *
     */
    abstract public function getView();
}

?>