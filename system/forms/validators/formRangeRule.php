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
 * formRangeRule: ��������� �������� ��������� ����� � ��������
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formRangeRule extends formAbstractRule
{
    public function validate()
    {
        if (!is_array($this->params) || !isset($this->params[0]) || !isset($this->params[1])) {
            throw new mzzRuntimeException('� ������� ����� ������� 2 ���������, ������������ ������ � ����� ���������');
        }

        return empty($this->value) || ($this->value >= $this->params[0] && $this->value <= $this->params[1]);
    }
}

?>