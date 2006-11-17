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
 * response: объект дл€ работы с информацией, выводимой клиенту в браузер
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
     * «аголовки
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
     * ”ставливает заголовки дл€ клиента
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * установка cookie
     *
     * @param string $name им€ cookie
     * @param string $value значение cookie
     * @param integer $expire врем€ жизни дл€ cookie
     * @param string $path путь в котором доступен cookie
     * @param string $domain домен в котором доступен cookie
     * @param boolean $secure указывает что cookie будет передано только при https-соединени
     * @param boolean $httponly указывает что cookie будет доступен только через протокол HTTP
     */
    public function setCookie($name, $value = '', $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false)
    {
        if (!$this->isHeadersSent()) {
            setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        }
    }

     /**
     * ”ставливает заголовок страницы
     *
     * @param $value
     */
    public function setTitle($value)
    {
        $this->smarty->assign('title', $value);
    }


    /**
     * ¬озвращает установленные заголовки дл€ клиента
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
     * @param string $string строка дл€ добавлени€
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
            if (!$this->isHeadersSent()) {
                foreach ($headers as $name => $value) {
                    header($name . ": " . $value);
                }
            }
        }
    }

    /**
     * Ѕросает исключение если заголовки были отправлены
     *
     * @return boolean
     */
    private function isHeadersSent()
    {
        if (headers_sent($file, $line)) {
            throw new mzzRuntimeException("Cannot modify header information - headers already sent in " . $file . " on line " . $line);
            return true;
        }
        return false;
    }

}

?>