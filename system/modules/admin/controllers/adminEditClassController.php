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

fileLoader::load('admin/views/adminEditClassView');

/**
 * adminEditClassController: ���������� ��� ������ editClass ������ admin
 *
 * @package modules
 * @subpackage admin
 * @version 0.1
 */
class adminEditClassController extends simpleController
{
    public function getView()
    {
        return new adminEditClassView();
    }
}

?>