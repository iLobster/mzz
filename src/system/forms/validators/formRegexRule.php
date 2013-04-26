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
 * formRegexRule: правило, определяющее валидность значения в соответствии с регулярным выражением
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formRegexRule extends formAbstractRule
{
    protected function _validate($value)
    {
        return (bool)preg_match($this->params, $value);
    }
}

?>