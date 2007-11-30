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
 * systemConfig: статический класс для хранения путей
 *
 * @package system
 * @version 0.2.1
 */
class systemConfig
{
    /**
     * Двумерный массив с данными для соединения с одной или несколькими БД
     * Необходима как минимум данные для одного соединения с алиасом 'default'
     * Ключем массива является алиас соединения, значение - массив с данными, где
     * ключи: driver, dbDsn, dbUser, dbPassword, dbCharset, pdoOptions
     *
     * @var array
     * @see DB::factory()
     */
    public static $db;

    /**
     * Путь до приложения
     *
     * @var string
     */
    public static $pathToApplication;

    /**
     * Путь до ядра
     *
     * @var string
     */
    public static $pathToSystem;

    /**
     * Путь до временной папки
     *
     * @var string
     */
    public static $pathToTemp;

    /**
     * Путь до файлов с конфигурацией
     *
     * @var string
     */
    public static $pathToConf;

    /**
     * Путь до каталога с тестами
     *
     * @var string
     */
    public static $pathToTests;

    /**
     * При вызове определяет и устанавливает путь до ядра
     *
     */
    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__);
    }
}

?>