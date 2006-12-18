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
 * adminViewController: контроллер для метода view модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */

fileLoader::load('admin/views/adminViewView');

class adminViewController extends simpleController
{
    public function getView()
    {
        $adminMapper = $this->toolkit->getMapper('admin', 'admin', 'admin');
        
        return new adminViewView($adminMapper->getInfo());
    }
}

?>