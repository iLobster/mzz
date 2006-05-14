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
 * pageFactory: фабрика для получения контроллеров страниц
 *
 * @package page
 * @version 0.4
 */

class pageFactory
{
    /**
     * Module action
     *
     * @var string
     */
    protected $action;

    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "page"; // оставить его здесь или брать из ТМ? Или тм должен брать отсюда?

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->action = $action;
        //$this->action->setDefaultAction('list');
        //$this->action->setAction($action->getAction());
    }

    /**
     * Загрузка и создание необходимого контроллера
     *
     * @return object
     */
    public function getController()
    {
        $action = $this->action->getAction();
        fileLoader::load($this->name . '/controllers/' . $this->name . '.' . $action['controller'] . '.controller');
        // тут возможно заменим константы news на метод $this->getName
        $classname = $this->name . ucfirst($action['controller']) . 'Controller';
        return new $classname();
    }


}
?>