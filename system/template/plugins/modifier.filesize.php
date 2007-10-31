<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * smarty_modifier_filesize: ������������ ����� � ����������� ������� ���������:
 * �����, ���������, ���������, ���������, ���������, ���������
 *
 * ������� �������������:<br />
 * <code>
 * {$size|filesize}
 * </code>
 *
 * @param integer $bytes ������ � ������
 * @return string
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_filesize($bytes)
{
    $bytes = max(0, (int) $bytes);
    $units = array('�', '��', '��', '��', '��', '��');
    $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
    return round($bytes / pow(1024, $power),2) . ' ' .$units[$power];
}
?>