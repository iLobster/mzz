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
 * simple403Controller: контроллер для метода 403 модуля simple
 *
 * @package modules
 * @subpackage simple
 * @version 0.1.2
 */

class simple403Controller extends simpleController
{
    public function getView()
    {
        $section = 'page';
        $action = 'view';
        $name = '403';

        if ($this->request->getSection() == $section
        && $this->request->getString('name') == $name
        && $this->request->getAction() == $action) {
            throw new mzzRuntimeException('Recursion detected: the 403 controller was called twice.');
        }

        $header = $this->request->getBoolean('403header');
        $this->request->setSection($section);
        $this->request->setParams(array('name' => $name));
        $this->request->setAction($action);

        if ($header) {
            $this->response->setStatus(403);
        }

        return $this->forward('page', 'view');
    }
}

?>
