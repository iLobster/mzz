<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * commentsDeleteController: контроллер для метода delete модуля comments
 *
 * @package modules
 * @subpackage comments
 * @version 0.1
 */

class commentsDeleteController extends simpleController
{
    protected function getView()
    {
        $commentsMapper = $this->toolkit->getMapper('comments', 'comments', 'comments');
        $commentsMapper->delete($this->request->get('id', 'integer', SC_PATH));

        return jipTools::redirect();
    }
}

?>