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
     * @var string
     */
    private $response = '';

    /**
     * ����������� ������
     *
     */
    public function __construct()
    {

    }

    /**
     * �������� ����������� �������
     *
     */
    public function send()
    {
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

}

?>