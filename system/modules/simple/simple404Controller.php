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
 * @version 0.1.4
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
        $section = 'page';
        $action = 'view';
        $name = '404';

        if ($this->request->getSection() == $section
        && $this->request->getString('name') == $name
        && $this->request->getAction() == $action) {
            throw new mzzRuntimeException('Recursion detected: the 404 controller was called twice.');
        }

        $this->request->setSection('page');
        $this->request->setParams(array('name' => '404'));
        $this->request->setAction('view');

        $this->response->setStatus(404);
        return $this->onlyHeaders ? false : $this->forward('page', 'view');
    }
}

?>
