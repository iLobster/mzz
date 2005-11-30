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
 * response: объект для работы с информацией, выводимой клиенту в браузер
 * 
 * @package system
 * @version 0.1
 */

class response
{
    /**
     * содержимое ответа
     *
     * @access private
     * @var string
     */
    private $response = '';

    /**
     * конструктор класса
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * отправка содержимого клиенту
     *
     * @access public
     */
    public function send()
    {
        $this->sendText();
    }

    /**
     * добавление информации к ответу
     *
     * @access public
     * @param string $string строка для добавления
     */
    public function append($string)
    {
        $this->response .= $string;
    }

    /**
     * отправление текста
     *
     * @access private
     */
    private function sendText()
    {
        echo $this->response;
    }

}

?>