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
 * news404Controller: ���������� ��� ������ 404 ������ news
 *
 * @package modules
 * @subpackage news
 * @version 0.1
 */

class news404Controller extends simpleController
{
    public function getView()
    {
        $this->response->setTitle('������. ������������� ������� ��� ����� �� �������.');
        return $this->smarty->fetch('news/notfound.tpl');
    }
}

?>