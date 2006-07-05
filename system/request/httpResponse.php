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
 * response: объект для работы с информацией, выводимой клиенту в браузер
 *
 * @package system
 * @subpackage request
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
     * Template Engine
     *
     * @var object
     */
    private $smarty;

    /**
     * конструктор класса
     *
     */
    public function __construct($smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * Уставливает заголовки для клиента
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

     /**
     * Уставливает заголовок страницы
     *
     * @param $value
     */
    public function setTitle($value)
    {
        $this->smarty->assign('title', $value);
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
        $this->sendHeaders();
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

    /**
     * отправление заголовков
     *
     */
    private function sendHeaders()
    {
        $headers = $this->getHeaders();
        if (!empty($headers)) {
            if (headers_sent($file, $line)) {
                throw new mzzRuntimeException("Cannot modify header information - headers already sent in " . $file . " on line " . $line);
            }
            foreach ($headers as $name => $value) {
                header($name . ": " . $value);
            }
        }
    }

}

?>