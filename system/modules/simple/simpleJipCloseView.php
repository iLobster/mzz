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
 * @package modules
 * @subpackage simple
 * @version $Id$
*/

/**
 * simpleJipCloseView: ����������� ��� ��� �������� JIP ����.
 * ��� �������� ���������� JIP ���� � ����������� ���������� �����,
 * ����������� ������� ���������� ������� JIP ����.
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
class simpleJipCloseView extends simpleView
{
    public function toString()
    {
        if (!$this->DAO) {
            $this->DAO = 1;
        }
        return '<script type="text/javascript"> jipWindow.close(' . $this->DAO . '); </script>';
    }
}

?>