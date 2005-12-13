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
    protected $tableModule;
    protected $smarty;
    protected $params;

    public function __construct($tableModule, $params = array())
    {
        $this->setModel($tableModule);
        $this->smarty = self::getSmarty();
        $this->params = $params;
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
        $registry = Registry::instance();
        return $registry->getEntry('smarty');
    }
}

?>