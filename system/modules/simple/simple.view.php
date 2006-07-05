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
 * @package simple
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
     * @var object
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
     * Конструктор
     *
     * Необходимые данные для отображения передаются в необязательном
     * аргументе $DAO
     *
     * @param mixed $DAO данные
     */
    public function __construct($DAO = null)
    {
        $toolkit = systemToolkit::getInstance();
        if(!is_null($DAO)) {
            $this->DAO = $DAO;
        }
        $this->smarty = $toolkit->getSmarty();
        $this->response = $toolkit->getResponse();

    }

    /**
     * Получение результата в виде строки
     *
     * @return string
     */
    public function toString()
    {
        return false;
    }

}

?>