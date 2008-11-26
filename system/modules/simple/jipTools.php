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
 * @version 0.3
 */
class jipTools
{
    /**
     * Закрытия одного или нескольких JIP окон.
     * Если $url === true, то после закрытия всех JIP-окон будет выполнено обновление окна браузера.
     * При значении, отличном от false и true, будет выполнено перенаправление браузера на указанный URL.
     *
     * @param integer $howMany сколько необходимо закрыть JIP окон. По умолчанию закрывается только одно - текущее
     * @param string|boolean $url true - обновить окно браузера, строка - редирект на данный URL
     * @param integer $timeout любые действия выполняются по истечению указаного количества миллисекунд
     * @return string HTML код
     */
    static public function closeWindow($howMany = 1, $url = false, $timeout = 1500)
    {
        $smarty = systemToolkit::getInstance()->getSmarty();
        $smarty->assign('url', $url);
        $smarty->assign('howMany', (int)$howMany);
        $smarty->assign('timeout', (int)$timeout);
        $smarty->assign('do', 'close');
        return $smarty->fetch('simple/jipTools.tpl');
    }

    static public function setRefreshAfterClose($url = true)
    {
        $smarty = systemToolkit::getInstance()->getSmarty();
        $smarty->assign('url', $url);
        $smarty->assign('do', 'refresh');
        return $smarty->fetch('simple/jipTools.tpl');
    }

    /**
     * Обновление окна браузера (deprecated: use self::refresh()) или перенаправление на другой URL
     *
     * @param string $url URL, на который будет отправлен пользователь. По умолчанию используется текущий URL браузера
     * @return string HTML код
     */
    static public function redirect($url = null)
    {
        $smarty = systemToolkit::getInstance()->getSmarty();
        $smarty->assign('url', $url);
        $smarty->assign('do', 'redirect');
        return $smarty->fetch('simple/jipTools.tpl');
    }

    /**
     * Обновление окна браузера
     *
     * @return string HTML код
     */
    static public function refresh()
    {
        $smarty = systemToolkit::getInstance()->getSmarty();
        $smarty->assign('url', null);
        $smarty->assign('do', 'redirect');
        return $smarty->fetch('simple/jipTools.tpl');
    }

}

?>