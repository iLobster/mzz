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
 * @version 0.1.5
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
     * Результат работы контроллера, обрабатывающего 404 ошибку конкретных ДО
     *
     * @var string
     */
    private $result;

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

    /**
     * Установка результата работы 404 контроллера для определенного маппера
     *
     * @param simpleMapper $mapper
     */
    public function applyMapper(mapper $mapper)
    {
        $this->result = $this->forward404($mapper);
    }

    protected function getView()
    {
        $this->response->setStatus(404);

        if ($this->result) {
            return $this->result;
        }

        $section = 'page';
        $action = 'view';
        $name = '404';

        if ($this->request->getSection() == $section && $this->request->getString('name') == $name && $this->request->getAction() == $action) {
            throw new mzzRuntimeException('Recursion detected: the 404 controller was called twice.');
        }

        $this->request->setSection('page');
        $this->request->setParams(array('name' => '404'));
        $this->request->setAction('view');

        return $this->onlyHeaders ? false : $this->forward('page', 'view');
    }
}

?>
