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
 * @package simple
 * @version 0.1
 */

abstract class simpleView
{
    protected $DAO;
    protected $smarty;
    protected $params;

    public function __construct($DAO)
    {
        $toolkit = systemToolkit::getInstance();
        $this->DAO = $DAO;
        $this->smarty = $toolkit->getSmarty();
        $this->response = $toolkit->getResponse();

    }

    public function toString()
    {
        return false;
    }

}

?>