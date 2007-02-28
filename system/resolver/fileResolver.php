<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * fileResolver: базовый резолвер, от которого наследуются все резолверы
 *
 * @package system
 * @subpackage resolver
 * @version 0.1.1
 */
class fileResolver implements iResolver
{
    /**
     * список паттернов (шаблонов имён файлов, имён файлов) для поиска
     *
     * @var array
     */
    private $pattern = '';

    /**
     * конструктор
     *
     * @param string $pattern паттерн для поиска
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }


    /**
     * запуск процесса поиска файла по паттернам
     *
     * @param string $request поисковый запрос
     * @return string|null путь до файла, если найден и null в противном случае
     */
    public function resolve($request)
    {
        $filename = str_replace('*', $request, $this->pattern);
        if (is_file($filename)) {
            return $filename;
        }
        return null;
    }
}

?>