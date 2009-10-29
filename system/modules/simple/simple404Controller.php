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
 * simple404Controller: контроллер страницы с ошибкой 404
 *
 * @package modules
 * @subpackage simple
 * @version 0.2
 */
class simple404Controller extends simpleController
{
    /**
     * Конструктор
     *
     * @param boolean $onlyHeaders
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    protected function getView()
    {
        $this->response->setStatus(404);
        return $this->smarty->fetch('simple/404.tpl');
    }

    public function run()
    {
        return $this->getView();
    }
}

?>