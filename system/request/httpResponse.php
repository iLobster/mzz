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
 * response: ������ ��� ������ � �����������, ��������� ������� � �������
 *
 * @package system
 * @subpackage request
 * @version 0.1
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
     * Template Engine
     *
     * @var object
     */
    private $smarty;

    /**
     * ����������� ������
     *
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
    public function setCookie($name, $value = '', $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false)
    {
        if (!$this->isHeadersSent()) {
            setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        }
    }

     /**
     * ����������� ��������� ��������
     *
     * @param $value
     */
    public function setTitle($value)
    {
        $this->smarty->assign('title', $value);
    }


    /**
     * ���������� ������������� ��������� ��� �������
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * �������� ����������� �������
     *
     */
    public function send()
    {
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
                    header($name . ": " . $value);
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