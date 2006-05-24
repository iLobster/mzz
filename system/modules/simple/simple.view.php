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
 * simpleView: реализация общих методов у видов
 *
 * @package simple
 * @version 0.1
 */

abstract class simpleView
{
    protected $DAO = false;
    protected $smarty;
    protected $params;

    public function __construct($DAO = false)
    {
        $toolkit = systemToolkit::getInstance();
        if($DAO) {
            $this->DAO = $DAO;
        }
        $this->smarty = $toolkit->getSmarty();
        $this->response = $toolkit->getResponse();

    }

    public function toString()
    {
        return false;
    }

}

?>