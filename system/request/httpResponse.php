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
     * Counter for headers with equal name
     *
     * @var integer
     */
    private $notReplacedCount = 0;

    /**
     * The response is a redirection
     *
     * @var boolean
     */
    protected $isRedirected = false;

    /**
     * Response status code
     */
    protected $status;

    /**
     * List of HTTP response codes
     *
     * @var array
     */
    protected $statusTexts = array(
    // Informational 1xx
    100 => 'Continue',
    101 => 'Switching Protocols',

    // Success 2xx
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',

    // Redirection 3xx
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',  // 1.1
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    // 306 is deprecated but reserved
    307 => 'Temporary Redirect',

    // Client Error 4xx
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',

    // Server Error 5xx
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    509 => 'Bandwidth Limit Exceeded'
    );

    /**
     * конструктор
     *
     */
    public function __construct()
    {
    }

    /**
     * Уставливает header для клиента. Если значение указано null, header удаляется.
     *
     * @param string $name имя header
     * @param string $value значение для заголовка
     * @param boolean $replaced указывает что заголовок должен замещать предыдущий с таким же именем
     *                          (например, для отправки "WWW-Authenticate" заголовков необходимо указать false)
     * @param integer|null $code
     */
    public function setHeader($name, $value, $replaced = true, $code = null)
    {
        if (is_null($value)) {
            unset($this->headers[$name]);
        }
        if ($replaced == false) {
            $name .= str_repeat('#', ++$this->notReplacedCount);
        }
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
     * Уставливает перенаправление на другую страницу
     *
     * @param string $url
     * @param integer $code 302...307
     */
    public function redirect($url, $code = 302)
    {
        $code = (int)$code;
        if ($code < 300 || $code > 307 || $code == 306) {
            throw new mzzRuntimeException('Invalid HTTP Redirection status code: ' . $code);
        }

        $this->isRedirected = true;

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

    public function setResponseText($response)
    {
        $this->response = $response;
    }

    public function getResponseText()
    {
        return $this->response;
    }

    /**
     * отправление заголовков
     *
     */
    private function sendHeaders()
    {
        // При редиректе заголовок устанавливается автоматически
        $status = $this->getStatus();
        if (!empty($status) && !$this->isRedirected) {
            header((php_sapi_name() == 'cgi' ? 'Status:' : 'HTTP/1.0') . ' ' . $status . ' ' . $this->statusTexts[$status]);
        }

        $headers = $this->getHeaders();
        if (empty($headers) || $this->isHeadersSent()) {
            return;
        }

        foreach ($headers as $name => $params) {
            $name = rtrim($name, '#');
            if (is_null($params['code'])) {
                header($name . ": " . $params['value'], $params['replaced']);
            } else {
                header($name . ": " . $params['value'], $params['replaced'], $params['code']);
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

        if (empty($cookies) || $this->isHeadersSent()) {
            return;
        }

        foreach ($cookies as $name => $values) {
            if(version_compare(phpversion(), '5.2', 'ge')) {
                setcookie($name, $values['value'], $values['expire'], $values['path'], $values['domain'], $values['secure'], $values['httponly']);
            } else {
                setcookie($name, $values['value'], $values['expire'], $values['path'], $values['domain'], $values['secure']);
            }
        }
    }

    /**
     * Устанавливает response status code
     *
     * @param integer $code
     */
    public function setStatus($code)
    {
        if (!isset($this->statusTexts[$code])) {
            throw new mzzRuntimeException('Unknown response status code ' . $code);
        }
        $this->status = (int)$code;
    }

    /**
     * Возвращает response status code
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Бросает исключение если заголовки уже были отправлены
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