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
 * iResolver: интерфейс ресолвера
 *
 * @package system
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