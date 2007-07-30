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
 * simple404Controller: контроллер для метода 404 модуля simple
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.2
 */

class simple404Controller extends simpleController
{
    /**
     * Свойство, определяющее - отправлять контент или только заголовки
     *
     * @var boolean
     */
    protected $onlyHeaders;

    /**
     * Конструктор
     *
     * @param boolean $onlyHeaders
     */
    public function __construct($onlyHeaders = false)
    {
        parent::__construct();
        $this->onlyHeaders = (bool)$onlyHeaders;
    }

    protected function getView()
    {
        $this->request->setSection('page');
        $this->request->setParams(array('name' => '404'));
        $this->request->setAction('view');

        $action = $this->toolkit->getAction('page');
        $action->setAction('view');

        fileLoader::load('pageFactory');

        $factory = new pageFactory($action);
        $controller = $factory->getController();

        $this->toolkit->getResponse()->setHeader('', 'HTTP/1.x 404 Not Found');

        return $this->onlyHeaders ? false : $controller->run();
        return false;
    }
}

?>