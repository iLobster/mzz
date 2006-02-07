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
 * TimerFactory: фабрика для получения контроллера таймера
 *
 * @package timer
 * @version 0.2
 */

class timerFactory
{
    // действие
    private $action;

    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "timer";

    // конструктор для фабрики
    function __construct($action)
    {
        $this->action = $action;
        $this->action->setDefaultAction('view');
    }

    // метод получения необходимого контроллера
    public function getController()
    {
        $action = $this->action->getAction();
        fileLoader::load($this->name . '.' . $action['controller'] . '.controller');
        // тут возможно заменим константы news на метод $this->getName
        $classname = $this->name . $action['controller'] . 'Controller';
        return new $classname();
    }
}

?>