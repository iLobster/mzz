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
 * formEqualRule: �������, �����������, ����� �� ��� �������� ��������
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formEqualRule extends formAbstractRule
{
    public function validate()
    {
        if (!isset($this->params[0])) {
            throw new mzzRuntimeException('����������� ��� ������ ���������� ��� ���������');
        }

        $second = systemToolkit::getInstance()->getRequest()->get($this->params[0], 'string', SC_REQUEST);

        if (is_null($second)) {
            throw new mzzRuntimeException('������ ���������� �� ����������');
        }

        return (!isset($this->params[1]) || $this->params[1]) ? $this->value == $second : $this->value != $second;
    }
}

?>