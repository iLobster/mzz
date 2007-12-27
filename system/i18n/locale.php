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
 * locale: класс для работы с локалями
 *
 * @package system
 * @subpackage i18n
 * @version 0.1
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
     * Идентификатор языка
     *
     * @var integer
     */
    private $langId;

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

        $this->data = parse_ini_file($this->locale_file, true);
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

    /**
     * Получение всех языков, определённых в системе
     *
     * @return array
     */
    public static function searchAll()
    {
        $db = db::factory();
        $stmt = $db->query('SELECT * FROM `sys_lang` ORDER BY `id`');

        $result = array();

        while ($row = $stmt->fetch()) {
            $tmp = new locale($row['name']);
            $tmp->setId($row['id']);
            $result[$row['id']] = $tmp;
        }

        return $result;

    }
}