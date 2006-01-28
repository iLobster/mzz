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
     * @var string
     */
    private $response = '';

    /**
     * конструктор класса
     *
     */
    public function __construct()
    {

    }

    /**
     * отправка содержимого клиенту
     *
     */
    public function send()
    {
        $this->sendText();
    }

    /**
     * добавление информации к ответу
     *
     * @param string $string строка для добавления
     */
    public function append($string)
    {
        $this->response .= $string;
    }

    /**
     * отправление текста
     *
     */
    private function sendText()
    {
        echo $this->response;
    }

}

?>