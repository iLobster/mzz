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
 * catalogueDeleteController: контроллер для метода delete модуля catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */

class catalogueDeleteController extends simpleController
{
    protected function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $id = $this->request->getInteger('id');
        $item = $catalogueMapper->searchByKey($id);

        if (!$item) {
            return $catalogueMapper->get404()->run();
        }

        $catalogueMapper->delete($item);

        return jipTools::redirect();
    }
}

?>