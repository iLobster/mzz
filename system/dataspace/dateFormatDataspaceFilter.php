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

fileLoader::load('dataspace/dataspaceFilter');

/**
 * dateFormatDataspaceFilter: фильтр для dataspace
 *
 * @package system
 * @version 0.1
 */
class dateFormatDataspaceFilter extends dataspaceFilter
{
    /**
     * Формат даты
     *
     * @var string
     */
    private $format;

    /**
     * Индексы
     *
     * @var array
     */
    private $keys;

    /**
     * Конструктор
     *
     * @param iDataspace $dataspace
     * @param array $keys
     * @param string $format формат даты
     */
    public function __construct(iDataspace $dataspace, Array $keys, $format = 'd M Y / H:i:s')
    {
        // возможно воткнуть какую то проверку на формат переменной $format
        // дефолтный формат возможно будет браться из конфига
        $this->format = $format;
        $this->keys = $keys;
        parent::__construct($dataspace);
    }

    /**
     * Возвращает значение по ключу
     *
     * @param string|intger $key ключ
     * @return mixed
     */
    public function get($key)
    {
        // может ещё проверять что запрашивается именно timestamp (is_int)
        // или форматировать при выводе.. хотя хз

        // что делать если значение == 0?
        if(in_array($key, $this->keys) && $this->dataspace->get($key) != 0) {
            return date($this->format, $this->dataspace->get($key));
        } else {
            return $this->dataspace->get($key);
        }

    }
}

?>