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
 * @subpackage resolver
 * @version $Id$
*/

/**
 * iResolver: интерфейс ресолвера
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */
interface iResolver
{

    /**
     * запуск процесса поиска файла по паттернам
     *
     * @param string $request поисковый запрос
     * @return string|null путь до файла, если найден и null в противном случае
     */
    public function resolve($request);
}

?>