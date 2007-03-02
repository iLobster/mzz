<?php
/**
 * $URL: http://svn.web/repository/mzz/system/modules/catalogue/controllers/catalogueDeletePropertyController.php $
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: catalogueDeletePropertyController.php 641 2007-03-02 22:39:51Z zerkms $
 */

/**
 * catalogueDeletePropertyController: ���������� ��� ������ deleteProperty ������ catalogue
 *
 * @package modules
 * @subpackage catalogue
 * @version 0.1
 */
 
class catalogueDeletePropertyController extends simpleController
{
    public function getView()
    {
        $catalogueMapper = $this->toolkit->getMapper('catalogue', 'catalogue');
        $id = $this->request->get('id', 'integer', SC_PATH);
        $catalogueMapper->deleteProperty($id);
        return jipTools::redirect();
    }
}

?>