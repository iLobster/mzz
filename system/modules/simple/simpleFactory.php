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
 * @package modules
 * @subpackage simple
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
    protected $name = "simple";

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
        $classname = $this->name . ucfirst($action['controller']) . 'Controller';
        fileLoader::load($this->name . '/controllers/' . $classname);
        return new $classname();
    }
}

?>