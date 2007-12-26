<?php

fileLoader::load('i18n/i18nStorage');

class i18nStorageIni implements i18nStorage
{
    private $data;

    public function __construct($module, $lang)
    {
        $file = fileLoader::resolve($module . '/' . $lang . '.i18n.ini');
        $this->data = parse_ini_file($file, true);
    }

    public function read($name)
    {
        if (sizeof($this->data[$name]) == 1) {
            return $this->data[$name][0];
        }

        return $this->data[$name];
    }
}