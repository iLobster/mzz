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

fileLoader::load('i18n/i18nStorageIni');

/**
 * i18n: класс для работы переводами
 *
 * @package system
 * @subpackage i18n
 * @version 0.1
 */
class i18n
{
    /**
     * Массив уже полученных фраз
     *
     * @var array
     */
    private $phrases = array();

    /**
     * Значение языка по-умолчанию
     *
     * @var string
     */
    private $default_language;

    /**
     * Текущий язык
     *
     * @var string
     */
    private $lang;

    /**
     * Массив стораджей, из которых производится выборка фраз
     *
     * @var array
     */
    private $storages = array();

    /**
     * Перевод фразы
     *
     * @param string $name идентификатор фразы
     * @param string $module имя модуля
     * @param string $lang язык
     * @param string|array $args аргументы
     * @param callback $generatorCallback callback на функцию-генератор кода, в случае когда в числе аргументов есть переменные
     * @return string результирующий перевод
     */
    public function translate($name, $module, $lang, $args = '', $generatorCallback = '')
    {
        if (is_bool($phrase = $this->search($name, $module, $lang))) {
            if ($lang == $this->getDefaultLang()) {
                return $name;
            }

            return $this->translate($name, $module, $this->getDefaultLang(), $args);
        }

        $this->lang = $lang;

        $phrase = $this->replacePlaceholders($phrase, $args, $generatorCallback);

        return $phrase;
    }

    /**
     * Определение - является ли аргумент переменной
     *
     * @param string $var
     * @param callback $generatorCallback
     * @return boolean
     */
    private function isVariable($var, $generatorCallback)
    {
        return (bool)$generatorCallback && strpos($var, '$') !== false;
    }

    /**
     * Разбиение строки аргументов в массив
     *
     * @param string $args
     * @return array
     */
    public function splitArguments($args)
    {
        return explode(' ', $args);
    }

    /**
     * Замена плейсхолдеров на конкретные значения
     *
     * @param string $phrase
     * @param string|array $args_str
     * @param callback $generatorCallback
     * @return string
     */
    public function replacePlaceholders($phrase, $args_str, $generatorCallback = false)
    {
        if (!is_array($args_str)) {
            if (!strlen($args_str)) {
                return $phrase;
            }

            $args = $this->splitArguments($args_str);
        } else {
            $args = $args_str;
        }

        $variables = array();

        if (strpos($phrase, ':1')) {
            $placeholders = array();
            $count = sizeof($args);

            for ($i = 1; $i <= $count; $i++) {
                if (!$this->isVariable($args[$i - 1], $generatorCallback)) {
                    $placeholders[] = ':' . $i;
                } else {
                    $variables[$i] = substr($args[$i - 1], 1);
                    unset($args[$i - 1]);
                }
            }

            $phrase = str_replace($placeholders, $args, $phrase);
        } else {
            $placeholderPosition = 0;
            foreach ($args as $value) {
                if (($placeholderPosition = strpos($phrase, '?', $placeholderPosition)) === false) {
                    break;
                }

                if (!$this->isVariable($value, $generatorCallback)) {
                    $phrase = substr_replace($phrase, $value, $placeholderPosition, 1);
                } else {
                    $placeholderPosition++;
                    $variables[] = substr($value, 1);
                }
            }
        }

        if ($variables) {
            $phrase = call_user_func_array($generatorCallback, array($phrase, $variables, $this->lang));
        }

        return $phrase;
    }

    /**
     * Определение формы фразы
     *
     * @param integer $number аргумент, от которого зависит форма
     * @param array $morphs массив форм
     * @param string $lang язык
     * @return string
     */
    public function morph($number, $morphs, $lang)
    {
        if (!is_array($morphs)) {
            $morphs = array($morphs);
        }

        $locale = new locale($lang);
        $plural = $this->calculatePlural($number, $locale);
        return $morphs[$plural];
    }

    /**
     * Вычисление номера формы по аргументу
     *
     * @param integer $number аргумент
     * @param string $locale имя локали
     * @return integer номер формы
     */
    private function calculatePlural($number, $locale)
    {
        if (is_string($number)) {
            return 0;
        }

        if (is_string($locale)) {
            $locale = new locale($locale);
        }

        $algo = $locale->getPluralAlgo();
        eval('$i = ' . $number . '; $plural = ' . $algo . ';');
        return $plural;
    }

    /**
     * Поиск фразы
     *
     * @param string $name
     * @param string $module
     * @param string $lang
     * @return string
     */
    private function search($name, $module, $lang)
    {
        if (isset($this->phrases[$module][$lang][$name])) {
            return $this->phrases[$module][$lang][$name];
        }

        if (empty($this->storages[$module][$lang])) {
            try {
                $this->storages[$module][$lang] = new i18nStorageIni($module, $lang);
            } catch (mzzIoException $e) {
                return false;
            }
        }

        $this->phrases[$module][$lang][$name] = $this->storages[$module][$lang]->read($name);

        return $this->phrases[$module][$lang][$name];
    }

    /**
     * Установка массива фраз, в обход метода search
     *
     * @param string $module
     * @param string $language
     * @param array $data
     * @see i18n::search()
     */
    public function setPhrases($module, $language, $data)
    {
        $this->phrases[$module][$language] = $data;
    }

    /**
     * Получение языка по умолчанию в приложении
     *
     * @return string
     */
    private function getDefaultLang()
    {
        if (empty($this->default_language)) {
            $this->default_language = systemConfig::$i18n;
        }

        return $this->default_language;
    }

    /**
     * Перевод фразы
     *
     * @param string $name
     * @param string $module
     * @param string $lang
     * @param string|array $args
     * @param callback $generatorCalback
     * @return unknown
     */
    public static function getMessage($name, $module, $lang, $args, $generatorCalback)
    {
        static $i18n;
        if (empty($i18n)) {
            $i18n = new i18n();
        }

        if (($slashpos = strpos($name, '/')) !== false) {
            $module = substr($name, 0, $slashpos);
            $name = substr($name, $slashpos + 1);
        }

        return $i18n->translate($name, $module, $lang, $args, $generatorCalback);
    }

    /**
     * Определение, является ли аргумент идентификатором фразы
     *
     * @param string $name
     * @return boolean
     */
    public static function isName($name)
    {
        return strpos($name, '_ ') === 0;
    }
}

?>