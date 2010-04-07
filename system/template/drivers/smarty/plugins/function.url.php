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
 * {url route="default" module="news" action="list"}
 * {url onlyPath=true}
 * {url route="guestbookActions" module="guestbook" action="delete" params="41"}
 * {url route="newsActions" module="news" params="2006/08/12"}
 * </code>
 *
 * GET-параметры задаются с префиксом "_". Примеры
 * <code>
 * {url route="default" module="news" action="list" _order="desc" _orderField="id"}
 * {url route="default" module="news" action="list" _order="desc" _orderField="id" appendGet=true}
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
    return $smarty->view()->plugin('url', $params);
}

?>