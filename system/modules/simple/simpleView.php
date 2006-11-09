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
     * @var mzzSmarty
     */
    protected $smarty;

    /**
     * ���������
     *
     * @var mixed
     * @deprecated it's true?
     */
    protected $params;


    /**
     * ������ Response
     *
     * @var iResponse
     */
    protected $response;

    /**
     * ������ Request
     *
     * @var iRequest
     */
    protected $httprequest;

    /**
     * ������ systemToolkit
     *
     * @var systemToolkit
     */
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
        $this->httprequest = $this->toolkit->getRequest();
        $this->smarty = $this->toolkit->getSmarty();
        /* @todo ��������� � true � �����������? */
        $this->smarty->allowNesting(!$this->httprequest->isAjax());
        $this->response = $this->toolkit->getResponse();
        $this->smarty->assign('current_section', $this->httprequest->getSection());
    }


    /**
     * ��������� ���������� � ���� ������
     *
     * @return string
     */
    abstract public function toString();
}

?>