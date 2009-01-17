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
    protected $multiple = true;

    public function validate()
    {
        if ($this->isMultiple) {
            foreach ($this->value as $value) {
                if ($this->testValue($value) == false) {
                    return false;
                }
            }
            return true;
        }

        return $this->testValue($this->value);
    }

    protected function testValue($value)
    {
        if (is_array($value)) {
            return count($value) > 0;
        }
        return trim($value) != '';
    }
}

?>