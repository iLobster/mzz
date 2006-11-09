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
    protected $httprequest;

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
        $this->httprequest = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        /* @todo установка в true в деструкторе? */
        $this->smarty->allowNesting(!$this->httprequest->isAjax());
        $this->response = $this->toolkit->getResponse();
        $this->smarty->assign('current_section', $this->httprequest->getSection());
    }


    /**
     * Получение результата в виде строки
     *
     * @return string
     */
    abstract public function toString();
}

?>