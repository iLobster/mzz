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
 * formDateRule: правило, проверяющее правильность даты и времени
 *
 * @package system
 * @subpackage forms
 * @version 0.1
 */
class formDateRule extends formAbstractRule
{
    /**
     * Проверяет дату на правильность. Работает с timestamp, со строками, формат которых
     * поддерживается функцией strtotime или массивом, где каждый элемент даты представлен
     * элементом ассоциативного массива (ключи таких массивов: year, month, day, hour, minute, second)
     *
     * @return boolean
     */
    protected function _validate($value)
    {
        if (is_array($value)) {
            $date = $this->convertDateArrayToTimestamp($value);
        } elseif (isset($this->params['regex'])) {
            if (!preg_match($this->params['regex'], $value, $match)) {
                return false;
            }
            $date = $this->convertDateArrayToTimestamp($match);
        } elseif (!is_numeric($value)) {
            $date = strtotime($value);
        } else {
            $date = false;
        }

        if ($date === false || $date < 0) {
            return false;
        }

        if (isset($this->params['min']) && $date < $this->params['min']) {
            return false;
        }

        if (isset($this->params['max']) && $date > $this->params['max']) {
            return false;
        }

        return true;
    }

    /**
     * Конвертирует массив из элементов даты в timestamp, если дата валидна
     *
     * @param array $date
     * @return integer|false
     */
    protected function convertDateArrayToTimestamp($date)
    {
        foreach (array('year', 'month', 'day', 'hour', 'minute', 'second') as $key) {
            $date[$key] = isset($date[$key]) ? (int)$date[$key] : 0;
            if(isset($date[$key]) && !empty($date[$key]) && !preg_match('#^\d+$#', $date[$key]) ) {
                return false;
            }
        }

        $empties = empty($date['year']) + empty($date['month']) + empty($date['day']);
        if ($empties > 0 && $empties < 3) {
            return false;
        } elseif ($empties == 3) {
            return true;
        }

        if ($date['hour'] + $date['minute'] + $date['second'] > 0) {
            if ($date['hour'] > 24 || $date['minute'] >= 60 || $date['second'] >= 60) {
                return false;
            }
        }
        return checkdate($date['month'], $date['day'], $date['year']);
    }
}

?>