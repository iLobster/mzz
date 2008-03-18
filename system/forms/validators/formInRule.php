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
 * formInRule: правило, проверяющее вхождение значения в определённую коллекцию
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formInRule extends formAbstractRule
{
    public function validate()
    {
        if (empty($this->value)) {
            return true;
        }

        if (!is_array($this->params)) {
            throw new mzzInvalidParameterException('Ожидается массив', $this->params);
        }

        if (!is_array($this->value)) {
            $this->value = array($this->value);
        }

        foreach ($this->value as $value) {
            if (!in_array($value, array_values($this->params))) {
                return false;
            }
        }

        return true;
    }
}

?>