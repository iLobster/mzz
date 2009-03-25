<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * simpleFactory: фабрика
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.1
 */
class simpleFactory
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
    protected $name;

    /**
     * Constructor
     *
     * @param string $action
     */
    public function __construct($action, $name)
    {
        $this->action = $action;
        $this->name = $name;
    }

    /**
     * Загрузка и создание необходимого контроллера
     *
     * @return object
     */
    public function getController($actionName)
    {
        $action = $this->action->getOptions($actionName);

        $toolkit = systemToolkit::getInstance();
        $toolkit->getRegistry()->set('isJip', $this->action->isJip($actionName));
        $toolkit->getRegistry()->set('confirm', isset($action['confirm']) ? $action['confirm'] : null);

        $classname = $this->name . ucfirst($action['controller']) . 'Controller';
        fileLoader::load($this->name . '/controllers/' . $classname);
        return new $classname();
    }
}

?>