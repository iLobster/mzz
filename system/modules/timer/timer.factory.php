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
 * @version 0.1
 */

class timerFactory
{
    // действие
    private $action;

    // действие по умолчанию
    private $defaultAction;

    // инстанция фабрики
    private static $instance;

    // конструктор для фабрики
    function __construct($action)
    {
        $this->setDefaultAction('view');
        $this->setAction($action);
    }

    // метод получения необходимого контроллера
    public function getController()
    {
        $action = $this->getAction();
        fileLoader::load('timer.' . $action['controller'] . '.controller');
        // тут возможно заменим константы news на метод $this->getName
        $classname = 'timer' . $action['controller'] . 'Controller';
        return new $classname();
    }

    // синглтон для фабрики
    public static function getInstance()
    {
        if ( !isset(self::$instance) ) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    // метод установки действия
    public function setAction($action)
    {
        $this->action = $this->checkAction( $action );
    }

    // метод получения действия
    public function getAction()
    {
        $actions = $this->getActions();
        $this->action = $this->checkAction( $this->action );
        return $actions[$this->action];
    }

    // метод получения списка действий
    private function getActions()
    {
        // возможно, даже почти наверняка список действий будет выглядеть немного
        // по другому, изменим когда будет нужно и будет получаться из хранилища
        // какого нить - типа xml, который будет идти к каждому модулю
        $actions = array(
        'view' => array(
        'controller' => 'view',
        ),
        );
        return $actions;
    }

    // установка действия по умолчанию
    public function setDefaultAction($action)
    {
        $this->defaultAction = $this->checkAction($action);
    }

    // получение действия по умолчанию
    public function getDefaultAction()
    {
        return $this->defaultAction;
    }

    // проверка действия
    private function checkAction($action)
    {
        $actions = $this->getActions();
        if ( !isset( $actions[$action] ) ) {
            $action = $this->getDefaultAction();
        }
        return $action;
    }
}