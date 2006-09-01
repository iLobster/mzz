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
 * systemConfig: статический класс для хранения путей
 *
 * @package system
 *
 */
class systemConfig {

    /**
     * Двумерный массив для хранения данных для соединения с другими бд
     * Ключем кеша является алиас соединения,
     * значение - массив с данными соединения. ключи - (driver, dbDsn, dbUser, dbPassword, dbCharset, pdoOptions).
     * если не указано какое то значение берется по умолчанию
     *
     * @var array
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
     * Включение/Отключение кэширования
     *
     * @var boolean
     */
    public static $cache;

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