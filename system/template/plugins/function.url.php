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
 * @package system
 * @subpackage template
 * @version $Id$
*/

/**
 * smarty_function_url: функция для смарти, генератор URL
 *
 * Примеры использования:<br />
 * <code>
 * {url route="default" section="news" action="list"}
 * {url route="guestbookActions" section="guestbook" action="delete" params="41"}
 * {url route="newsActions" section="news" params="2006/08/12"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @subpackage template
 * @version 0.2
 */
function smarty_function_url($params, $smarty)
{
    $toolkit = systemToolkit::getInstance();
    $request = $toolkit->getRequest();
    $getUrl = false;
    $appendGet = false;

    if (isset($params['appendGet'])) {
        $appendGet = (bool)$params['appendGet'];
        unset($params['appendGet']);
    }

    if(!isset($params['route'])){
        $getUrl = true;
        $params['route'] = null;
    }

    $onlyPath = false;
    if(isset($params['onlyPath'])){
        $onlyPath = true;
        unset($params['onlyPath']);
    }

    $url = new url($params['route']);
    unset($params['route']);

    if ($appendGet) {
        foreach ($request->exportGet() as $get_key => $get_value) {
            $url->add($get_key, $get_value, true);
        }
    }

    foreach ($params as $name => $value) {
        if ($isGet = $name[0] == '_') {
            $name = substr($name, 1);
        }
        $url->add($name, $value, $isGet);
    }

    if ($getUrl == true) {
        return $onlyPath ? SITE_PATH . '/' . $request->getPath() : $request->getRequestUrl();
    } else {
        return $url->get();
    }
}

?>
