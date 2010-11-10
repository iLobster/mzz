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
 * @version 0.3
 */
class simple404Controller extends simpleController
{
    protected function getView()
    {
        throw new mzzException("deprecated, use module errorPages");
        
        $this->response->setStatus(404);

        $template = 'simple/404.tpl';
        
        return $this->view->render($template);
    }
}

?>