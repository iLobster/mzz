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
     * Тип драйвера БД
     *
     * @var string
     */
    public static $dbDriver;


    //Значения по умолчанию
    /**
     * Data Source Name
     *
     * @var string
     */
    public static $dbDsn;

    /**
     * Имя пользователя для доступа к БД
     *
     * @var string
     */
    public static $dbUser;

    /**
     * Пароль для доступа к БД
     *
     * @var string
     */
    public static $dbPassword;

    /**
     * Кодировка БД
     *
     * @var string
     */
    public static $dbCharset;

    /**
     * Опции соединения с базой данных для PDO
     *
     * @var array
     */
    public static $pdoOptions;


    // Дополнительные соединения
    /**
     * Двумерный массив для хранения данных для соединения с другими бд
     * Ключем кеша является альяс соединения,
     * значение - массив с данными соединения(ключи dbDsn, dbUser, dbPassword, dbCharset, pdoOptions).
     * если не указано какое то значение берется дефолтное
     *
     * @var array
     */
    public static $dbMulti;


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