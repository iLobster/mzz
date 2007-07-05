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
 * formRegexRule: �������, ������������ ���������� �������� � ������������ � ���������� ����������
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formRegexRule extends formAbstractRule
{
    public function validate()
    {
        return empty($this->value) || preg_match($this->params, $this->value);
    }
}

?>