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
 * response: ������ ��� �������� ���������� � ����������, ������������ �������
 *
 * @package system
 * @subpackage request
 * @version 0.1.1
 */

class httpResponse
{
    /**
     * ���������� ������
     *
     * @var string
     */
    private $response = '';

    /**
     * ���������
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
     * ����������� ������
     *
     * @param object $smarty ������ Template Engine
     */
    public function __construct($smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * ����������� ��������� ��� �������
     *
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * ��������� cookie
     *
     * @param string $name ��� cookie
     * @param string $value �������� cookie
     * @param integer $expire ����� ����� ��� cookie
     * @param string $path ���� � ������� �������� cookie
     * @param string $domain ����� � ������� �������� cookie
     * @param boolean $secure ��������� ��� cookie ����� �������� ������ ��� https-���������
     * @param boolean $httponly ��������� ��� cookie ����� �������� ������ ����� �������� HTTP
     */
    public function setCookie($name, $value = '', $expire = 0, $path = SITE_PATH, $domain = '', $secure = false, $httponly = false)
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
     * ����������� ��������� ��������
     *
     * @param string $value
     */
    public function setTitle($value)
    {
        $this->smarty->assign('title', $value);
    }

    /**
     * ����������� ��������������� �� ������ ��������
     *
     * @param string $url
     */
    public function redirect($url)
    {
        $this->setHeader('Location', $url);
    }

    /**
     * ���������� ������������� ��������� �������
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * ���������� ������������� cookies �������
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * �������� ����������� �������
     *
     */
    public function send()
    {
        $this->sendCookies();
        if ($this->smarty->isXml()) {
            $this->setHeader('Content-type', 'text/xml');
        }
        $this->sendHeaders();
        $this->sendText();
    }

    /**
     * ���������� ���������� � ������
     *
     * @param string $string ������ ��� ����������
     */
    public function append($string)
    {
        $this->response .= $string;
    }

    /**
     * ������� ������
     *
     */
    public function clear()
    {
        $this->response = '';
    }

    /**
     * ����������� ������
     *
     */
    private function sendText()
    {
        echo $this->response;
    }

    /**
     * ����������� ����������
     *
     */
    private function sendHeaders()
    {
        $headers = $this->getHeaders();
        if (!empty($headers)) {
            if (!$this->isHeadersSent()) {
                foreach ($headers as $name => $value) {
                    if ($name) {
                        header($name . ": " . $value);
                    } else {
                        header($value);
                    }
                }
            }
        }
    }

    /**
     * ����������� cookies
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
     * ������� ���������� ���� ��������� ���� ����������
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