<?php
/**
 * $URL: svn://svn.subversion.ru/usr/local/svn/mzz/trunk/system/i18n/locale.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: locale.php 3918 2009-11-02 05:58:39Z striker $
 */

fileLoader::load('service/iniFile');

/**
 * fLocale: класс для работы с локалями
 *
 * @package system
 * @subpackage i18n
 * @version 0.1.6
 */
class fLocale
{
    /**
     * Путь до файла локали
     *
     * @var string
     */
    private $locale_file;

    /**
     * Данные файла локали
     *
     * @var array
     */
    private $data;

    /**
     * Имя локали
     *
     * @var string
     */
    private $name;

    /**
     * Переведённое имя локали
     *
     * @var string
     */
    private $translated_name;

    /**
     * Идентификатор языка
     *
     * @var integer
     */
    private $langId;

    /**
     * Массив для хранения найденных локалей
     *
     * @var array
     */
    private static $langs = false;

    /**
     * @var cache
     */
    private $cache;

    /**
     * Конструктор
     *
     * @param string $lang
     */
    public function __construct($lang)
    {
        try {
            $this->locale_file = $this->resolve($this->name = $lang);
        } catch (mzzIoException $e) {
            throw new mzzLocaleNotFoundException($lang);
        }

        $file = new iniFile($this->locale_file);
        $this->data = $file->read();

        $this->cache = systemToolkit::getInstance()->getCache('long');
    }

    /**
     * Резолв файла локали по имени локали
     *
     * @param string $name
     * @return string
     */
    private function resolve($name)
    {
        return fileLoader::resolve('i18n/' . $name . '.ini');
    }

    /**
     * Получение имени страны
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->data['regional_settings']['country'];
    }

    /**
     * Получение имени языка
     *
     * @return string
     */
    public function getLanguageName()
    {
        return $this->data['regional_settings']['language_name'];
    }

    /**
     * Получение числа форм
     *
     * @return integer
     */
    public function getPluralsCount()
    {
        return (int)$this->data['plural']['count'];
    }

    /**
     * Получение алгоритма вычисления форм
     *
     * @return string
     */
    public function getPluralAlgo()
    {
        return $this->data['plural']['algo'];
    }

    /**
     * Возвращает алфавит
     *
     * @return string
     */
    public function getAlphabet()
    {
        return $this->data['regional_settings']['alphabet'];
    }

    /**
     * Является ли язык с направлением письма "справа налево"
     *
     * @return boolean
     */
    public function isRtl()
    {
        return $this->data['regional_settings']['text_direction'] == 'rtl';
    }

    /**
     * Получение имени локали
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Получение идентификатора языка
     *
     * @return integer
     */
    public function getId()
    {
        static $ids;

        if (empty($this->langId) && !isset($ids[$this->name])) {
            $cache_key = 'lang_' . $this->name;
            if (!$this->cache->get($cache_key, $this->langId)) {
                $db = fDB::factory();
                $stmt = $db->query('SELECT `id` FROM `' . $db->getTablePrefix() . 'sys_lang` WHERE `name` = ' . $db->quote($this->name));
                $this->langId = (int)$stmt->fetchColumn();

                $this->cache->set($cache_key, $this->langId, array(
                    'lang'));
            }
            $ids[$this->name] = $this->langId;
        }

        return !empty($this->langId) ? $this->langId : $ids[$this->name];
    }

    /**
     * Установка идентификатора языка
     *
     * @param integer $id
     */
    protected function setId($id)
    {
        $this->langId = $id;
    }

    /**
     * Установка переведённого названия языка
     *
     * @param string $name
     */
    protected function setTranslatedName($name)
    {
        $this->translated_name = $name;
    }

    /**
     * Получение переведённого названия языка
     *
     * @return string
     */
    public function getTranslatedName()
    {
        if (empty($this->translated_name)) {
            $locale = self::searchAll($this->getId());
            $this->setTranslatedName($locale->getTranslatedName());
        }

        return $this->translated_name;
    }

    /**
     * Получение формата времени
     *
     * @param boolean $long
     * @return string
     */
    public function getTimeFormat($long = false)
    {
        return $long ? $this->data['date_time']['time_format'] : $this->data['date_time']['short_time_format'];
    }

    /**
     * Получение формата даты
     *
     * @param boolean $long
     * @return string
     */
    public function getDateFormat($long = false)
    {
        return $long ? $this->data['date_time']['date_format'] : $this->data['date_time']['short_date_format'];
    }

    /**
     * Получение формата даты и времени
     *
     * @param boolean $longDate
     * @param boolean $longTime
     * @return string
     */
    public function getDateTimeFormat($longDate = false, $longTime = false)
    {
        if ($longDate && $longTime) {
            return $this->data['date_time']['date_time_format'];
        } elseif (!$longDate && $longTime) {
            return $this->data['date_time']['short_date_time_format'];
        }

        return $this->data['date_time']['short_date_short_time_format'];
    }

    /**
     * Получение формата напрямую из массива данных
     *
     * @param string $name
     * @return string
     */
    public function getDateTimeFormatDirectly($name)
    {
        return isset($this->data['date_time'][$name . '_format']) ? $this->data['date_time'][$name . '_format'] : $this->getDateTimeFormat();
    }

    /**
     * Получение всех языков, определённых в системе
     *
     * @param string|array $id Поиск по id конкретного языка (набора языков)
     * @return array
     */
    public static function searchAll($id = null)
    {
        static $cache;

        if (is_null($cache)) {
            $cache = systemToolkit::getInstance()->getCache('long');
        }

        $cache_key = 'lang_all';
        if (self::$langs === false) {
            if (!$cache->get($cache_key, $result)) {
                $db = fDB::factory();
                $stmt = $db->query('SELECT `d`.`id`, `d`.`name`, `l`.`name` AS `title` FROM `' . $db->getTablePrefix() . 'sys_lang` `d` LEFT JOIN `' . $db->getTablePrefix() . 'sys_lang_lang` `l` ON `l`.`id` = `d`.`id` AND `l`.`lang_id` = ' . systemToolkit::getInstance()->getLang() . ' ORDER BY `id`');

                $result = array();

                while ($row = $stmt->fetch()) {
                    $tmp = new fLocale($row['name']);
                    $tmp->setId($row['id']);
                    $tmp->setTranslatedName($row['title'] ? $row['title'] : $tmp->getLanguageName());
                    $result[$row['id']] = $tmp;
                }

                $cache->set($cache_key, $result, array(
                    'lang'));
            }

            self::$langs = $result;
        }

        if (is_string($id)) {
            foreach (self::$langs as &$lang) {
                if ($lang->getName() == $id) {
                    return $lang;
                }
            }

            return null;
        }

        if (is_array($id)) {
            $result = array();
            foreach ($id as $current) {
                if (isset(self::$langs[$current])) {
                    $result[$current] = self::$langs[$current];
                }
            }

            return $result;
        }

        if ($id) {
            return isset(self::$langs[$id]) ? self::$langs[$id] : null;
        }

        return self::$langs;
    }

    /**
     * Проверка существования языка в таблице sys_lang
     *
     * @param string $name имя языка
     * @return array
     */
    public static function isExists($name)
    {
        return !is_null(self::searchAll($name));
    }

    /**
     * Строка локали, формируемая для функции setlocale()
     *
     * @return string
     */
    public function getForSetlocale()
    {
        return $this->data['http']['content_language'] . '.' . $this->data['charset']['preferred'];
    }

    /**
     * Получение локализованных имён месяцев
     *
     * @return array
     */
    public function getLongMonthNames()
    {
        return $this->data['long_month_names'];
    }

    /**
     * Получение склонённых локализованных имён месяцев, либо конкретного месяца
     *
     * @param integer $number
     * @return string|array
     */
    public function getLongMonthNamesDecline($number = 0)
    {
        if ($number >= 1 && $number <= 12) {
            return $this->data['long_month_names_decline'][$number];
        }

        return $this->data['long_month_names_decline'];
    }

    /**
     * Получение списка временных зон
     *
     * @return array
     */
    public function getGmtList()
    {
        $array = range(-12, 12);
        return array_combine($array, $array);
    }
}

?>