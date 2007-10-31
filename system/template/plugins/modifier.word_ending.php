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
 * smarty_modifier_word_ending: ����������� ������ ��� ����� ����� � ���������� ���������
 *
 * ������� �������������:<br />
 * <code>
 * {$comments|@sizeof|word_ending:"������������,�����������,�����������"}
 * </code>
 * � ��������� ��������� ������ ����� ���� ��� ����� 10, 11 � �.�, ������ ��� 1 � �.�., ������� ��� 2 � �.�.
 *
 * @param integer $num �����
 * @param string $words ��� ����� ����� �������: ��� ����� 5, ��� 1, ��� 2
 * @return string ����� � ����� � ���������� ���������� ����� ������
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_modifier_word_ending($num, $words)
{
    $words = explode(",", $words);
    $real_num = $num;
    $num = abs($num);
    $index = $num % 100;
    if ($index >=11 && $index <= 14) {
        $index = 0;
    } else {
        $index = (($index %= 10) < 5 ? ($index > 2 ? 2 : $index): 0);
    }
    
    return $real_num . ' ' . trim($words[$index]);
}
?>