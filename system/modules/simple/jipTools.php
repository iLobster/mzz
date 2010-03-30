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
        $view = systemToolkit::getInstance()->getView('smarty');
        $view->assign('url', $url);
        $view->assign('howMany', (int)$howMany);
        $view->assign('timeout', (int)$timeout);
        $view->assign('do', 'close');
        return $view->render('simple/jipTools.tpl');
    }

    static public function setRefreshAfterClose($url = true)
    {
        $view = systemToolkit::getInstance()->getView('smarty');
        $view->assign('url', $url);
        $view->assign('do', 'refresh');
        return $view->render('simple/jipTools.tpl');
    }

    /**
     * Обновление окна браузера (deprecated: use self::refresh()) или перенаправление на другой URL
     *
     * @param string $url URL, на который будет отправлен пользователь. По умолчанию используется текущий URL браузера
     * @return string HTML код
     */
    static public function redirect($url = null)
    {
        $view = systemToolkit::getInstance()->getView('smarty');
        $view->assign('url', $url);
        $view->assign('do', 'redirect');
        return $view->render('simple/jipTools.tpl');
    }

    /**
     * Обновление окна браузера
     *
     * @return string HTML код
     */
    static public function refresh()
    {
        $view = systemToolkit::getInstance()->getView('smarty');
        $view->assign('url', null);
        $view->assign('do', 'redirect');
        return $view->render('simple/jipTools.tpl');
    }

}

?>