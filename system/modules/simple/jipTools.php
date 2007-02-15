<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package modules
 * @subpackage simple
 * @version $Id$
*/

/**
 * jipTools: инструменты для работы с jip-окнами
 *
 * @package modules
 * @subpackage simple
 * @version 0.1
 */
class jipTools
{
    /**
     * Закрытия одного или нескольких JIP окон
     *
     * @param integer $howMany сколько необходимо закрыть JIP окон. По умолчанию закрывается только одно - текущее
     * @param string|boolean $url true - обновить окно браузера, строка - редирект на данный URL
     * @return string HTML код
     */
    static public function closeWindow($howMany = 1, $url = false)
    {
        $html = '<script type="text/javascript"> ';
        if ($url) {
            $url = ($url === true) ? 'true' : '"' . $url . '"';
            $html .= 'jipWindow.refreshAfterClose(' . $url .'); ';
        }
        $html .= 'jipWindow.close(' . (int)$howMany . '); </script>';
        return $html;
    }

    /**
     * Обновление окна браузера или перенаправление на другой URL
     *
     * @param string $url URL, на который будет отправлен пользователь. По умолчанию используется текущий URL браузера
     * @return string HTML код
     */
    static public function redirect($url = null)
    {
        $html = '<script type="text/javascript"> var toUrl = ';
        $html .= (!empty($url)) ? '"' . $url . '"' : "new String(window.location).replace(window.location.hash, '')";
        $html .= '; window.location = (toUrl.substring(toUrl.length - 1) != "#") ? toUrl : toUrl.substring(0, toUrl.length - 1); </script><p align="center"><span id="jipLoad">Обновление окна браузера...</span></p>';
        return $html;
    }
}

?>