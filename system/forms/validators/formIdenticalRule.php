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
    public function validate()
    {
        if (empty($this->params)) {
            throw new mzzRuntimeException('Необходимо указать поле с котором сравнивается значение');
        }

        $request = systemToolkit::getInstance()->getRequest();
        $value_second = $request->getString($this->params, SC_REQUEST);

        if ($this->isEmpty() && empty($value_second)) {
            return true;
        }

        return $this->value === $value_second;
    }
}

?>