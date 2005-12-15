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
 * IMzzSmarty: модификация Smarty для работы с шаблонами
 *
 * @version 0.3
 * @package system
 */


interface IMzzSmarty
{
    /**
     * Выполняет шаблон и возвращает результат
     * Декорирован для реализации вложенных шаблонов.
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     * @param object $smarty
     */
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false, mzzSmarty $smarty);

    /**
     * Получает и возвращает относительный путь к исходнику шаблонов.
     * Если нужный шаблон находится в корне папки с шаблонами, то изменений нет,
     * если в корне нет, то к относительному путю прибавляется первая часть имени до точки.
     *
     * Пример:
     * <code>
     * news.view.tpl -> news/news.view.tpl
     * main.tpl -> main.tpl
     * </code>
     *
     * @param string $name
     * @param object $smarty
     * @return string
     */
    function getResourceFileName($name, mzzSmarty $smarty);


}

?>
