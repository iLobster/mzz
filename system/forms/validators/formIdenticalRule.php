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
 * formIdenticalRule: правило, проверяющее что значение поле равно значению другого поля
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 * @deprecated думаю что на совпадение типов переменных нет повода проверять, предлагаю оставить только formEqualRule
 */
class formIdenticalRule extends formAbstractRule
{
    protected function _validate($value)
    {
        if (empty($this->params)) {
            throw new mzzRuntimeException('Необходимо указать поле с котором сравнивается значение');
        }

        if (!isset($this->data[$this->params[0]])) {
            throw new mzzRuntimeException('Вторая переменная не определена');
        }

        $second = $this->data[$this->params[0]];

        return $value === $second;
    }
}

?>