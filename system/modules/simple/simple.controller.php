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
 * simpleController: реализация общих методов у контроллеров
 *
 * @package simple
 * @version 0.1
 */

abstract class simpleController
{
    protected $toolkit;
    protected $request;

    public function __construct()
    {
        $this->toolkit = systemToolkit::getInstance();
        $this->request = $this->toolkit->getRequest();
    }

    abstract public function getView();
}

?>