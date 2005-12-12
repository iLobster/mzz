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
 * fileResolver: базовый резолвер, от которого наследуются все резолверы
 *
 * @package system
 * @subpackage resolver
 * @version 0.1
 */

class fileResolver
{
    /**
     * список паттернов (шаблонов имён файлов, имён файлов) для поиска
     *
     * @var array
     */
    private $patterns = array();
    
    /**
     * конструктор
     *
     * @param string $pattern паттерн для поиска
     */
    public function __construct($pattern)
    {
        $this->addPattern($pattern);
    }
    
    /**
     * метод добавления паттернов в список
     *
     * @param string $pattern паттерн для поиска
     */
    public function addPattern($pattern)
    {
        $this->patterns[] = $pattern;
    }
    
    /**
     * запуск процесса поиска файла по паттернам
     *
     * @param string $request поисковый запрос
     * @return string|null путь до файла, если найден и null в противном случае
     */
    public function resolve($request)
    {
        foreach ($this->patterns as $filename) {
            $filename = str_replace('*', $request, $filename);
            //echo $filename . '<br>';
            if (is_file($filename)) {
                return $filename;
            }
        }
        return null;
    }
}

?>