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
    protected function _validate($value)
    {
        if (!is_array($this->params)) {
            throw new mzzInvalidParameterException('Ожидается массив', $this->params);
        }

        if (!is_array($value)) {
            $value = array($value);
        }

        foreach ($value as $current_value) {
            if (!in_array($current_value, array_values($this->params))) {
                return false;
            }
        }

        return true;
    }
}

?>