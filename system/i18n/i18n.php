<?php

class i18n
{
    private $phrases = array();
    private $default_language;

    public function translate($name, $module, $lang, $args = '', $generatorCallback = '')
    {
        if (is_bool($phrase = $this->search($name, $module, $lang))) {
            if ($lang == $this->getDefaultLang()) {
                return $name;
            }

            return $this->translate($name, $module, $this->getDefaultLang(), $args);
        }

        $phrase = $this->replacePlaceholders($phrase, $args, $generatorCallback);

        return $phrase;
    }

    private function isVariable($var, $generatorCallback)
    {
        return (bool)$generatorCallback && strpos($var, '$') !== false;
    }

    public function replacePlaceholders($phrase, $args_str, $generatorCallback = false)
    {
        if (!strlen($args_str)) {
            return $phrase;
        }

        $args = explode(' ', $args_str);

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
            $phrase = call_user_func_array($generatorCallback, array($phrase, $variables));
        }

        return $phrase;
    }

    private function search($name, $module, $lang)
    {
        if (isset($this->phrases[$module][$lang][$name])) {
            return $this->phrases[$module][$lang][$name];
        }

        return false;
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

        return $i18n->translate($name, $module, $lang, $args, $generatorCalback);
    }
}

?>