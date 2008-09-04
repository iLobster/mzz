<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/filters/i18nFilter.php $
 *
 * MZZ Content Management System (c) 2008
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage filters
 * @version $Id: i18nFilter.php 2547 2008-06-25 10:00:29Z mz $
*/
/**
 * userPreferences: пользовательские runtime-настройки приложения
 *
 * @package service
 * @version 0.1
 */
class userPreferences
{
    static public $skinVarName = 'mzz_skin';
    static public $langVarName = 'mzz_i18n_language';
    static public $tzVarName = 'mzz_i18n_timezone';
    static public $tzDefaultVarName = 'mzz_i18n_timezone_default';

    public function __construct()
    {
        $this->session = systemToolkit::getInstance()->getSession();
    }

    public function getSkin()
    {
        return $this->session->get(self::$skinVarName);
    }

    public function getTimezone()
    {
        return $this->session->get(self::$tzVarName);
    }

    public function getLang()
    {
        return $this->session->get(self::$langVarName);
    }

    public function getDefaultTimezone()
    {
        return $this->session->get(self::$tzDefaultVarName);
    }
}


?>