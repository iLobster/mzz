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
 */
class systemConfig {

    /**
     * Тип драйвера БД
     *
     * @var string
     */
    public static $dbDriver;

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
     * Опции соединения с базой данных для PDO
     *
     * @var array
     */
    public static $pdoOptions;

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