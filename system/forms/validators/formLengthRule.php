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
 * formLengthRule: правило, проверяющее длину строки
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formLengthRule extends formAbstractRule
{
    public function validate()
    {
        if (empty($this->value)) {
            return true;
        }

        $length = strlen($this->value);

        if (is_integer($this->params)) {
            return $length >= $this->params;
        }

        if (is_array($this->params) && array_key_exists(0, $this->params) && array_key_exists(1, $this->params)) {
            if (is_null($this->params[0])) {
                return $length <= $this->params[1];
            }

            return $length >= $this->params[0] && $length <= $this->params[1];
        }

        throw new mzzRuntimeException('Отствуют необходимые аргументы');
        /*if (!isset($this->params[0])) {
        throw new mzzRuntimeException('Отсутствует имя второй переменной для сравнения');
        }

        $second = systemToolkit::getInstance()->getRequest()->get($this->params[0], 'string', SC_REQUEST);

        if (is_null($second)) {
        throw new mzzRuntimeException('Вторая переменная не определена');
        }

        return (!isset($this->params[1]) || $this->params[1]) ? $this->value == $second : $this->value != $second;*/
    }
}

?>