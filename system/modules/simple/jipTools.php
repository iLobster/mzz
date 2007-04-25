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
     * Закрытия одного или нескольких JIP окон.
     * Если $url == true, то после закрытия всех JIP-окон будет выполнено обновление окна браузера.
     * При значении, отличном от false и true, будет выполнено перенаправление браузера на указанный URL.
     *
     * @param integer $howMany сколько необходимо закрыть JIP окон. По умолчанию закрывается только одно - текущее
     * @param string|boolean $url true - обновить окно браузера, строка - редирект на данный URL
     * @param integer $timeout любые действия выполняются по истечению указаного количества миллисекунд
     * @return string HTML код
     */
    static public function closeWindow($howMany = 1, $url = false, $timeout = 1500)
    {
        $html = '<script type="text/javascript"> window.setTimeout(function() {';
        if ($url) {
            $url = ($url === true) ? 'true' : '"' . $url . '"';
            $html .= 'jipWindow.refreshAfterClose(' . $url .'); ';
        }
        $html .= 'jipWindow.close(' . (int)$howMany . '); }, ' . (int)$timeout . '); </script>';
        $html .= '<p style="text-align: center; font-weight: bold; color: green; font-size: 120%;">Сохранение изменений...</p>';
        return $html;
    }

    static public function setRefreshAfterClose($url = true)
    {
        $html = '<script type="text/javascript"> jipWindow.refreshAfterClose(';
        $html .= ($url === true) ? 'true' : '"' . $url . '"';
        $html .= '); </script>';
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