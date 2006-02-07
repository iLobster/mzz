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
 * TimerFactory: ������� ��� ��������� ����������� �������
 *
 * @package timer
 * @version 0.2
 */

class timerFactory
{
    // ��������
    private $action;

    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = "timer";

    // ����������� ��� �������
    function __construct($action)
    {
        $this->action = $action;
        $this->action->setDefaultAction('view');
    }

    // ����� ��������� ������������ �����������
    public function getController()
    {
        $action = $this->action->getAction();
        fileLoader::load($this->name . '.' . $action['controller'] . '.controller');
        // ��� �������� ������� ��������� news �� ����� $this->getName
        $classname = $this->name . $action['controller'] . 'Controller';
        return new $classname();
    }
}

?>