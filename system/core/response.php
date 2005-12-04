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
 * response: ������ ��� ������ � �����������, ��������� ������� � �������
 * 
 * @package system
 * @version 0.1
 */

class response
{
    /**
     * ���������� ������
     *
     * @access private
     * @var string
     */
    private $response = '';

    /**
     * ����������� ������
     *
     * @access public
     */
    public function __construct()
    {

    }

    /**
     * �������� ����������� �������
     *
     * @access public
     */
    public function send()
    {
        $this->sendText();
    }

    /**
     * ���������� ���������� � ������
     *
     * @access public
     * @param string $string ������ ��� ����������
     */
    public function append($string)
    {
        $this->response .= $string;
    }

    /**
     * ����������� ������
     *
     * @access private
     */
    private function sendText()
    {
        echo $this->response;
    }

}

?>