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

    if(isset($params['section'])) {
        $url->setSection($params['section']);
    }

    if(isset($params['action'])) {
        $url->setAction($params['action']);
    }

    if(isset($params['params'])) {
        $url->addParam($params['params']);
    }

    return $url->get();
}

?>