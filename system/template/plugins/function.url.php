<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//
/**
 * smarty_function_url: функция для смарти, генератор URL
 *
 * Примеры использования:<br />
 * <code>
 * {url section="news"}
 * {url section="guestbook" action="delete" param="41"}
 * {url section="news" param="2006/08/12"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @version 0.1
 */
function smarty_function_url($params, $smarty)
{
    $url = new url();

    $getUrl = true;

    if (isset($params['section'])) {
        $getUrl = false;
        $url->setSection($params['section']);
    }

    if (isset($params['action'])) {
        $getUrl = false;
        $url->setAction($params['action']);
    }

    if (isset($params['params'])) {
        $getUrl = false;
        $url->addParam($params['params']);
    }

    if ($getUrl == true) {
        $toolkit = systemToolkit::getInstance();
        $request = $toolkit->getRequest();
        return $request->getUrl();
    } else {
        return $url->get();
    }
}

?>