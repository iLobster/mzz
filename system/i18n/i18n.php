<?php

fileLoader::load('i18n/i18nStorageIni');

class i18n
{
    private $phrases = array();
    private $default_language;
    private $lang;
    private $storages;

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

    private function isVariable($var, $generatorCallback)
    {
        return (bool)$generatorCallback && strpos($var, '$') !== false;
    }

    public function splitArguments($args)
    {
        return explode(' ', $args);
    }

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

    public function morph($number, $morphs, $lang)
    {
        if (!is_array($morphs)) {
            $morphs = array($morphs);
        }

        $locale = new locale($lang);
        $plural = $this->calculatePlural($number, $locale);
        return $morphs[$plural];
    }

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

    public function setPhrases($module, $language, $data)
    {
        $this->phrases[$module][$language] = $data;
    }

    private function getDefaultLang()
    {
        if (empty($this->default_language)) {
            $this->default_language = systemConfig::$i18n;
        }

        return $this->default_language;
    }

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

    public static function isName($name)
    {
        return strpos($name, '_ ') === 0;
    }
}

?>