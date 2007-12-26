<?php

fileLoader::load('i18n/i18nStorageIni');

class i18nStorageIniTest extends UnitTestCase
{
    public function testRead()
    {
        $storage = new i18nStorageIni('news', 'ru');
        $this->assertEqual($storage->read('title'), 'Название');
    }
}