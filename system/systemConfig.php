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
     * Путь до приложения
     *
     * @static 
     * @var string
     */
    public static $pathToApplication;

    /**
     * Путь до ядра
     *
     * @static 
     * @var string
     */
    public static $pathToSystem;

    /**
     * Путь до временной папки
     *
     * @static 
     * @var string
     */
    public static $pathToTemp;

    /**
     * Путь до файлов с конфигурацией
     *
     * @static 
     * @var string
     */
    public static $pathToConf;

    /**
     * При вызове определяет и устанавливает путь до ядра
     *
     * @access public
     * @static 
     */
    public static function init()
    {
        self::$pathToSystem = dirname(__FILE__) . '/';
    }
}

?>