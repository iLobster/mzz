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
 * newsDeleteController: контроллер для метода delete модуля news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */
class newsDeleteController extends simpleController
{
    public function getView()
    {
        $newsMapper = $this->toolkit->getMapper('news', 'news');
        $newsMapper->delete($this->request->get('id', 'integer', SC_PATH));

        $url = new url('default2');
        $url->setAction('list');

        return jipTools::redirect($url->get());
    }
}

?>