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
 * page404View: ����������� ������ 404
 *
 * @package modules
 * @subpackage page
 * @version 0.1
 */
class page404View extends simpleView
{

    public function toString()
    {
        $this->response->setTitle('������. ������������� �������� �� �������.');
        return $this->smarty->fetch('page/notfound.tpl');
    }
}

?>