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
 * adminGenerateObjIdController: контроллер для метода generateObjId модуля admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminGenerateObjIdController extends simpleController
{
    public function getView()
    {
        $obj_id = $this->toolkit->getObjectId();

        $session = $this->toolkit->getSession();
        $session->set('admin_obj_id', $obj_id);

        $this->smarty->assign('obj_id', $obj_id);
        return $this->smarty->fetch('admin/generateObjId.tpl');
    }
}

?>