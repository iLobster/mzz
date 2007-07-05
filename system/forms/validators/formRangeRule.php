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
 * @version 0.1
 */
class formRangeRule extends formAbstractRule
{
    public function validate()
    {
        return $this->value >= $this->params[0] && $this->value <= $this->params[1];
    }
}

?>