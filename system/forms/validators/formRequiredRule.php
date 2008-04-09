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
 * formRequiredRule: правило, определяющее, что значение поле обязательно должно быть заполнено
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formRequiredRule extends formAbstractRule
{
    public function validate()
    {
        if (is_array($this->value)) {
            return count($this->value) > 0 && array_sum($this->value) > 0;
        }
        return trim($this->value) != '';
    }
}

?>