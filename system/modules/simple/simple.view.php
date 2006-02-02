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

class simpleView
{
    protected $DAO;
    protected $smarty;
    protected $params;

    public function __construct($DAO)
    {
        $this->DAO = $DAO;
        $this->smarty = self::getSmarty();
    }

    public function toString()
    {
        return false;
    }

    /** � ����� �� ���� �����?
    private function setDao($DAO)
    {
        $this->DAO = $DAO;
    }
    */

    private function getSmarty()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getSmarty();
    }
}

?>