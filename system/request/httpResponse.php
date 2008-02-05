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
 * response: объект для хранения информации и заголовков, отправляемой клиенту
 *
 * @package system
 * @subpackage request
 * @version 0.1.1
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
     * Cookies
     *
     * @var array
     */
    private $cookies = array();

    /**
     * Template Engine
     *
     * @var object
     */
    private $smarty;

    /**
     * конструктор класса
     *
     * @param object $smarty объект Template Engine
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
    public function setHeader($name, $value, $replaced = true, $code = null)
    {
        $this->headers[$name] = array('value' => $value, 'replaced' => $replaced, 'code' => $code);
    }

    /**
     * установка cookie
     *
     * @param string $name имя cookie
     * @param string $value значение cookie
     * @param integer $expire время жизни для cookie
     * @param string $path путь в котором доступен cookie
     * @param string $domain домен в котором доступен cookie
     * @param boolean $secure указывает что cookie будет передано только при https-соединени
     * @param boolean $httponly указывает что cookie будет доступен только через протокол HTTP
     */
    public function setCookie($name, $value = '', $expire = 0, $path = SITE_PATH, $domain = COOKIE_DOMAIN, $secure = false, $httponly = false)
    {
        $this->cookies[$name] = array(
        'value' => $value,
        'expire' => $expire,
        'path' => $path ? $path : '/',
        'domain' => $domain,
        'secure' => $secure,
        'httponly' => $httponly
        );
    }

    /**
     * Уставливает заголовок страницы
     *
     * @param string $value
     */
    public function setTitle($value)
    {
        $this->smarty->assign('title', $value);
    }

    /**
     * Уставливает перенаправление на другую страницу
     *
     * @param string $url
     * @param boolean $exit
     * @param integer $code
     */
    public function redirect($url, $exit = false, $code = 302)
    {
        $code = (int)$code;
        if ($code < 300 || $code > 307) {
            throw new mzzRuntimeException('Invalid HTTP Redirection status code: ' . $code);
        }

        $this->setHeader('Location', $url, true, $code);
    }

    /**
     * Возвращает установленные заголовки клиенту
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Возвращает установленные cookies клиенту
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * отправка содержимого клиенту
     *
     */
    public function send()
    {
        $this->sendCookies();
        /*if ($this->smarty->isXml()) {
        $this->setHeader('Content-type', 'text/xml');
        }*/
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
     * Очистка ответа
     *
     */
    public function clear()
    {
        $this->response = '';
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
                foreach ($headers as $name => $params) {
                    if (!$name) {
                        header($params['value']);
                    } elseif (is_null($params['code'])) {
                        header($name . ": " . $params['value'], $params['replaced']);
                    } else {
                        header($name . ": " . $params['value'], $params['replaced'], $params['code']);
                    }
                }
            }
        }
    }

    /**
     * отправление cookies
     *
     */
    private function sendCookies()
    {
        $cookies = $this->getCookies();
        if (!empty($cookies)) {
            if (!$this->isHeadersSent()) {
                foreach ($cookies as $name => $values) {
                    if(version_compare(phpversion(), '5.2', 'ge')) {
                        setcookie($name, $values['value'], $values['expire'], $values['path'], $values['domain'], $values['secure'], $values['httponly']);
                    } else {
                        setcookie($name, $values['value'], $values['expire'], $values['path'], $values['domain'], $values['secure']);
                    }
                }
            }
        }
    }

    /**
     * Бросает исключение если заголовки были отправлены
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