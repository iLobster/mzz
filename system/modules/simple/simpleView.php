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
 * simpleView: реализация общих методов у видов
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

abstract class simpleView
{
    /**
     * Данные
     *
     * @var object|false
     */
    protected $DAO = false;

    /**
     * Объект шаблонного движка
     *
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * Параметры
     *
     * @var mixed
     * @deprecated it's true?
     */
    protected $params;


    /**
     * Объект Response
     *
     * @var iResponse
     */
    protected $response;

    /**
     * Объект Request
     *
     * @var iRequest
     */
    protected $request;

    /**
     * Объект systemToolkit
     *
     * @var systemToolkit
     */
    protected $toolkit;

    /**
     * Конструктор
     *
     * Необходимые данные для отображения передаются в необязательном
     * аргументе $DAO
     *
     * @param mixed $DAO данные
     */
    public function __construct($DAO = null)
    {
        $this->toolkit = systemToolkit::getInstance();
        if(!is_null($DAO)) {
            $this->DAO = $DAO;
        }
        $this->request = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();

        $this->response = $this->toolkit->getResponse();

        if ($this->toolkit->getRegistry()->get('isJip') && $this->request->isAjax()) {
            $this->smarty->setActiveXmlTemplate('main.xml.tpl');
            $this->response->setHeader('Content-Type', 'text/xml');
        }
    }


    /**
     * Получение результата в виде строки
     *
     * @return string
     */
    abstract public function toString();
}

?>
