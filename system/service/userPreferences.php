<?php
/**
 * $URL$
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
 * @version $Id$
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

    public function setSkin($skin)
    {
        $this->setSessionVar(self::$skinVarName, $skin);
    }

    public function setTimezone($tz)
    {
        $this->setSessionVar(self::$tzVarName, $tz);
    }

    public function setLang($lang)
    {
        $this->setSessionVar(self::$langVarName, $lang);
    }

    public function setDefaultTimezone($tz)
    {
        $this->setSessionVar(self::$tzDefaultVarName, $tz);
    }

    protected function setSessionVar($name, $value)
    {
        if ($value === null) {
            $this->session->destroy($name);
        }
        $this->session->set($name, $value);
    }

    public function clear()
    {
        $this->session->destroy(self::$langVarName);
        $this->session->destroy(self::$tzVarName);
        $this->session->destroy(self::$tzDefaultVarName);
        $this->session->destroy(self::$skinVarName);
    }
}


?>