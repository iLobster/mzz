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
 * {load module="some_module_name" action="some_action"}
 *
 * @param array $params входные аргументы функции
 * @param object $smarty объект смарти
 * @return string результат работы модуля
 * @package system
 * @version 0.1
 */
function smarty_function_url($params, $smarty) {
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

    return $url->getFull();
}

?>