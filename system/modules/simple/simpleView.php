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
 * simpleView: ���������� ����� ������� � �����
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */

abstract class simpleView
{
    /**
     * ������
     *
     * @var object|false
     */
    protected $DAO = false;

    /**
     * ������ ���������� ������
     *
     * @var object
     */
    protected $smarty;

    /**
     * ���������
     *
     * @var mixed
     * @deprecated it's true?
     */
    protected $params;

    protected $response;

    protected $toolkit;

    /**
     * �����������
     *
     * ����������� ������ ��� ����������� ���������� � ��������������
     * ��������� $DAO
     *
     * @param mixed $DAO ������
     */
    public function __construct($DAO = null)
    {
        $this->toolkit = systemToolkit::getInstance();
        if(!is_null($DAO)) {
            $this->DAO = $DAO;
        }
        $this->smarty = $this->toolkit->getSmarty();
        $this->response = $this->toolkit->getResponse();
        $this->httprequest = $this->toolkit->getRequest();

    }

    /**
     * ��������� ���������� � ���� ������
     *
     * @return string
     */
    public function toString()
    {
        return false;
    }

}

?>