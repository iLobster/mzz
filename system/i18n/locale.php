<?php

class locale
{
    private $locale_file;
    private $data;
    private $name;
    private $langId;

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

    private function resolve($name)
    {
        return fileLoader::resolve('i18n/' . $name . '.ini');
    }

    public function getCountry()
    {
        return $this->data['regional_settings']['country'];
    }

    public function getId()
    {
        if (empty($this->langId)) {
            $db = db::factory();
            $stmt = $db->query('SELECT `id` FROM `sys_lang` WHERE `name` = ' . $db->quote($this->name));
            $this->langId = $stmt->fetchCol();
        }

        return $this->langId;
    }
}