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

class simpleView
{
    protected $tableModule;
    protected $smarty;
    protected $params;

    public function __construct($tableModule)
    {
        $this->setModel($tableModule);
        $this->smarty = self::getSmarty();
    }

    public function toString()
    {
        return false;
    }

    private function setModel($tableModule)
    {
        $this->tableModule = $tableModule;
    }

    private function getSmarty()
    {
        $toolkit = systemToolkit::getInstance();
        return $toolkit->getSmarty();
    }
}

?>