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

fileLoader::load('service/iniFile');

/**
 * locale: класс для работы с локалями
 *
 * @package system
 * @subpackage i18n
 * @version 0.1.2
 */
class locale
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

    private static $langs = false;

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
            // @todo: сделать получение дефолтного языка
            $this->locale_file = $this->resolve($this->name = 'en');
        }

        $file = new iniFile($this->locale_file);
        $this->data = $file->read();
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
        if (empty($this->langId)) {
            $db = db::factory();
            $stmt = $db->query('SELECT `id` FROM `sys_lang` WHERE `name` = ' . $db->quote($this->name));
            $this->langId = (int)$stmt->fetchColumn();
        }

        return $this->langId;
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

    protected function setTranslatedName($name)
    {
        $this->translated_name = $name;
    }

    public function getTranslatedName()
    {
        return $this->translated_name;
    }

    public function getTimeFormat($long = false)
    {
        return $long ? $this->data['date_time']['time_format'] : $this->data['date_time']['short_time_format'];
    }

    public function getDateFormat($long = false)
    {
        return $long ? $this->data['date_time']['date_format'] : $this->data['date_time']['short_date_format'];
    }

    public function getDateTimeFormat($longDate = false, $longTime = false)
    {
        if ($longDate && $longTime) {
            return $this->data['date_time']['date_time_format'];
        } elseif (!$longDate && $longTime) {
            return $this->data['date_time']['short_date_time_format'];
        }

        return $this->data['date_time']['short_date_short_time_format'];
    }

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
        if (self::$langs === false) {
            $db = db::factory();
            $stmt = $db->query('SELECT `d`.`id`, `d`.`name`, `l`.`name` AS `title` FROM `sys_lang` `d` LEFT JOIN `sys_lang_lang` `l` ON `l`.`id` = `d`.`id` AND `l`.`lang_id` = ' . systemToolkit::getInstance()->getLang() . ' ORDER BY `id`');

            $result = array();

            while ($row = $stmt->fetch()) {
                $tmp = new locale($row['name']);
                $tmp->setId($row['id']);
                $tmp->setTranslatedName($row['title'] ? $row['title'] : $tmp->getLanguageName());
                $result[$row['id']] = $tmp;
            }

            self::$langs = $result;
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

    public function getGmtList()
    {
        $array = range(-12, 12);
        return array_combine($array, $array);
    }
}