<?php

fileLoader::load('i18n/fLocale');

class fLocaleTest extends UnitTestCase
{
    private $db;

    public function __construct()
    {
        $this->db = fDB::factory();
        $this->tearDown();
    }

    public function setUp()
    {
        $this->db->query("INSERT INTO `sys_lang` (`id`, `name`, `title`) VALUES (1, 'ru', 'ру'), (2, 'en', 'en')");
    }

    public function tearDown()
    {
        $this->db->query('TRUNCATE TABLE `sys_lang`');
    }

    public function testGetLocale()
    {
        $locale = new fLocale('ru');
        $this->assertEqual($locale->getCountry(), 'Russian Federation');
        $this->assertEqual($locale->getLanguageName(), 'Russian');
        $this->assertEqual($locale->getName(), 'ru');
    }

    public function testGetAllLocales()
    {
        $locales = fLocale::searchAll();
        $this->assertEqual(sizeof($locales), 2);

        $this->assertEqual($locales[1]->getCountry(), 'Russian Federation');
        $this->assertEqual($locales[2]->getCountry(), 'USA');
    }

    public function testMorphs()
    {
        $locale = new fLocale('ru');
        $this->assertEqual($locale->getPluralsCount(), 3);
        $this->assertEqual($locale->getPluralAlgo(), '($i % 10 == 1 && $i % 100 != 11 ? 0 : ($i % 10 >= 2 && $i % 10 <= 4 && ($i % 100 < 10 || $i % 100 >= 20) ? 1 : 2))');
    }
}

?>