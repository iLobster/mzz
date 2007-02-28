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
 * user404View: ����������� ������ 404
 *
 * @package modules
 * @subpackage user
 * @version 0.1
 */
class user404View extends simpleView
{
    public function toString()
    {
        $this->response->setTitle('������. ������������� ������������ �� ������.');
        return $this->smarty->fetch('user/notfound.tpl');
    }
}

?>