<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/forms/validators/formCallbackRule.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: formCallbackRule.php 2836 2008-11-27 02:24:56Z mz $
 */

/**
 * formCallbackwmsgRule: правило проверки по callback-функции с возвращением текста ошибки
 * callback-функция должна иметь вид function myCallbackFunction( $value, $msg [, mixed $parameter [, mixed $... ]] )
 *
 * @package system
 * @subpackage forms
 * @version 0.1.1
 */
class formCallbackwmsgRule extends formAbstractRule
{
    protected function _validate($value)
    {
        $funcName = array_shift($this->params);
        if (!is_callable($funcName)) {
            throw new Exception('Указанная функция ' . (is_array($funcName) ? get_class($funcName[0]) . '::' . $funcName[1] : $funcName) . ' не является валидным callback\'ом');
        }
        return call_user_func_array($funcName, array_merge(array($value, &$this->message), $this->params));
    }
}

?>