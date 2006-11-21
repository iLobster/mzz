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
 * {url section="news"}
 * {url section="guestbook" action="delete" params="41"}
 * {url section="news" params="2006/08/12"}
 * </code>
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @subpackage template
 * @version 0.1
 */
function smarty_function_url($params, $smarty)
{
    $url = new url();

    $toolkit = systemToolkit::getInstance();
    $getUrl = true;

    if (isset($params['section'])) {
        $getUrl = false;
        $url->setSection($params['section']);
        unset($params['section']);
    }

    if (isset($params['action'])) {
        $getUrl = false;
        $url->setAction($params['action']);
        unset($params['action']);
    }

    if (isset($params['route'])) {
        $router = $toolkit->getRouter();
        $url->setRoute($router->getRoute($params['route']));
        unset($params['route']);
    }

    foreach ($params as $name => $value) {
        $url->addParam($name, $value);
    }

    if ($getUrl == true) {
        $request = $toolkit->getRequest();
        return $request->getRequestUrl();
    } else {
        return $url->get();
    }
}

?>