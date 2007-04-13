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
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');

        $id = $this->request->get('id', 'integer', SC_PATH);
        $catalogue = $catalogueMapper->searchById($id);

        if($catalogue){
            $catalogueMapper->delete($id);
        }

        return jipTools::redirect();
    }
}

?>