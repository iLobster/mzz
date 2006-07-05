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
 * simpleFactory: фабрика
 *
 * @package simple
 * @version 0.1
 */
abstract class simpleFactory
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
    protected $name = "simple"; // оставить его здесь или брать из ТМ? Или тм должен брать отсюда?

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action)
    {
        $this->action = $action;
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