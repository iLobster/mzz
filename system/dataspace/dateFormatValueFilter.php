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

fileLoader::load('dataspace/iValueFilter');

/**
 * dateFormatValueFilter: фильтр для dataspace.
 * Приводит unix timestamp к нормальному формату
 *
 * @package system
 * @version 0.1
 */
class dateFormatValueFilter implements iValueFilter
{
    /**
     * Формат даты
     *
     * @var string
     */
    private $format;

    /**
     * Конструктор
     *
     * @param string $format формат даты
     */
    public function __construct($format = 'd M Y / H:i:s')
    {
        // возможно воткнуть какую то проверку на формат переменной $format
        // дефолтный формат возможно будет браться из конфига
        $this->format = $format;
    }

    /**
     * Возвращает значение по ключу
     *
     * @param string|intger $key ключ
     * @return mixed
     */
    public function filter($value)
    {
        // может ещё проверять что запрашивается именно timestamp (is_int)
        // или форматировать при выводе.. хотя хз

        return date($this->format, $value);
    }
}

?>