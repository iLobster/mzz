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
 * formEqualRule: rule checks for equality of field value and second value passed manually
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formEqualtoRule extends formAbstractRule
{
    protected function _validate($value)
    {
        if (!isset($this->params[0])) {
            throw new mzzRuntimeException('Second value for comparison missed');
        }

        return (!is_array($this->params[0])) ? $value == $this->params[0] : !count(array_diff($value, $this->params[0]));
    }
}

?>