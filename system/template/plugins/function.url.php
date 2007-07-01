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

    if(!isset($params['route'])){
        $getUrl = true;
        $params['route'] = null;
    }

    $url = new url($params['route']);

    if (isset($params['section'])) {
        //$getUrl = false;
        $url->setSection($params['section']);
        unset($params['section']);
    } else {
        $url->setSection($request->getSection());
    }

    foreach ($params as $name => $value) {
        $url->addParam($name, $value);
    }

    if ($getUrl == true) {
        return $request->getRequestUrl();
    } else {
        return $url->get();
    }
}

?>