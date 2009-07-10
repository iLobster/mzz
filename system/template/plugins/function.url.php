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
 * При вызове без аргументов возвращает текущий URL. При вызове с аргументом onlyPath,
 * только текущий путь от корня (может быть удобно в случае использования AJAX)
 *
 *
 * Примеры использования:<br />
 * <code>
 * {url route="default" section="news" action="list"}
 * {url onlyPath=true}
 * {url route="guestbookActions" section="guestbook" action="delete" params="41"}
 * {url route="newsActions" section="news" params="2006/08/12"}
 * </code>
 *
 * GET-параметры задаются с префиксом "_". Примеры
 * <code>
 * {url route="default" section="news" action="list" _order="desc" _orderField="id"}
 * {url route="default" section="news" action="list" _order="desc" _orderField="id" appendGet=true}
 * </code>
 * сгенерирует /news/list/?order=desc&orderField=id и /news/list/?order=desc&orderField=id&page=3 соответственно
 * (page=3 как пример того, что может уже содержаться в GET-параметрах)
 * Текущие GET-параметры позволяет сохранить параметр appendGet
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @subpackage template
 * @version 0.2.2
 */
function smarty_function_url($params, $smarty)
{
    $toolkit = systemToolkit::getInstance();
    $request = $toolkit->getRequest();

    if (!empty($params['current'])) {
        return $request->getRequestUrl();
    }

    $getUrl = false;
    $appendGet = false;

    if (isset($params['appendGet'])) {
        $appendGet = (bool)$params['appendGet'];
        unset($params['appendGet']);
    }

    if (!isset($params['route'])) {
        $getUrl = true;
        $params['route'] = null;
    }

    if (isset($params['lang']) || !isset($params['route'])) {
        $getUrl = false;
        try {
            $route = $toolkit->getRouter()->getCurrentRoute();
        } catch (mzzNoRouteException $e) {
            $route = $toolkit->getRouter()->getDefaultRoute();
        }
        if (!isset($params['lang']) && !isset($params['route'])) {
            $params = $params + $request->getRequestedParams();
            $params['action'] = $request->getRequestedAction();
            $params['module'] = $request->getRequestedModule();
        } else {
            $params = $params + $request->getParams();
            $params['action'] = $request->getAction();
            $params['module'] = $request->getModule();
        }
        $params['route'] = $route->getName();
    }

    $onlyPath = false;
    if (isset($params['onlyPath'])){
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

    if ($onlyPath) {
        $url->disableAddress();
    }

    if (isset($params['lang'])){
        try {
            $finishedUrl = $url->get();
        } catch (mzzRuntimeException $e) {
            // it was wrong route, now try the default one
            $url->setRoute($toolkit->getRouter()->getDefaultRoute()->getName());
            $finishedUrl = $url->get();
        }
        return $finishedUrl;
    }

    $url = $url->get();

    if (isset($params['escape']) && $params['escape']) {
        $url = htmlspecialchars($url);
    }

    return $url;
}

?>