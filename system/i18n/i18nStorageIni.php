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

fileLoader::load('i18n/i18nStorage');

/**
 * i18nStorageIni: класс для получения переводов из ini-файлов
 *
 * @package system
 * @subpackage i18n
 * @version 0.1
 */
class i18nStorageIni implements i18nStorage
{
    /**
     * Массив фраз
     *
     * @var array
     */
    private $data = array();

    /**
     * Конструктор
     *
     * @param string $module имя модуля
     * @param string $lang язык
     */
    public function __construct($module, $lang)
    {
        $file = fileLoader::resolve($module . '/i18n/' . $lang . '.ini');
        $this->data = parse_ini_file($file, true);
    }

    /**
     * Получение фразы по идентификатору
     *
     * @param string $name
     */
    public function read($name)
    {
        if (sizeof($this->data[$name]) == 1) {
            return $this->data[$name][0];
        }

        return $this->data[$name];
    }
}