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
 * formCallbackRule: правило проверки по callback-функции
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formCallbackRule extends formAbstractRule
{
    public function validate()
    {
        if ($this->isEmpty()) {
            return true;
        }
        $funcName = array_shift($this->params);
        if (!is_callable($funcName)) {
            throw new Exception('Указанная функция ' . (is_array($funcName) ? get_class($funcName[0]) . '::' . $funcName[1] : $funcName) . ' не является валидным callback\'ом');
        }
        return call_user_func_array($funcName, array_merge(array($this->value), $this->params));
    }
}

?>