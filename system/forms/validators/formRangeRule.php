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
 * formRangeRule: валидатор проверки вхождения числа в диапазон
 *
 * @package system
 * @subpackage forms
 * @version 0.1.2
 */
class formRangeRule extends formAbstractRule
{
    public function validate()
    {
        if (!is_array($this->params)|| !array_key_exists(0, $this->params) || !array_key_exists(1, $this->params) || (is_null($this->params[0]) && is_null($this->params[1]))) {
            throw new mzzRuntimeException('В массиве нужно указать 2 параметра, обозначающих начало и конец интервала');
        }

        if (is_null($this->value)) {
            return true;
        }

        if (is_null($this->params[0]) || is_null($this->params[1])) {
            return is_null($this->params[1]) ? $this->value >= $this->params[0] : $this->value <= $this->params[1];
        } else {
            return $this->value >= $this->params[0] && $this->value <= $this->params[1];
        }
    }
}

?>