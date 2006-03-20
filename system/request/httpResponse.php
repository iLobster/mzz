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

class httpResponse
{
    /**
     * содержимое ответа
     *
     * @var string
     */
    private $response = '';

    /**
     * Заголовки
     *
     * @var array
     */
    private $headers = array();

    /**
     * конструктор класса
     *
     */
    public function __construct()
    {

    }

    /**
     * Уставливает заголовки для клиента
     *
     * @param $name
     * @param $value
     */
    public function sendHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Возвращает установленные заголовки для клиента
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
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
     * отправление заголовков и текста
     *
     */
    private function sendText()
    {
        $headers = $this->getHeaders();
        if(!empty($headers)) {
            if(headers_sent($file, $line)) {
                throw new mzzRuntimeException("Cannot modify header information - headers already sent in " . $file . " on line " . $line);
            }
            foreach ($headers as $name => $value) {
                header($name . ": " . $value);
            }
        }

        echo $this->response;
    }

}

?>