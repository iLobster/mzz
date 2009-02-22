<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/plugins/i18nPlugin');
fileLoader::load('cases/orm/ormSimple');

class ormSimpleI18nMapper extends mapper
{
    protected $table = 'ormSimple';

    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array(
                'pk')),
        'foo' => array(
            'accessor' => 'getFoo',
            'mutator' => 'setFoo'),
        'bar' => array(
            'accessor' => 'getBar',
            'mutator' => 'setBar'),
        'title' => array(
            'accessor' => 'getTitle',
            'mutator' => 'setTitle',
            'options' => array(
                'i18n')));
}

class pluginI18nTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $default_locale;

    public function __construct()
    {
        $this->db = DB::factory();
        $this->cleardb();

        $this->default_locale = systemConfig::$i18n;
    }

    private function fixture()
    {
        $valString = '';
        for ($id = 1; $id <= 3; $id++) {
            $valString .= "(" . $id . ", 'foo" . $id . "', 'bar" . $id . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`, `bar`) VALUES ' . $valString);

        $this->db->query('INSERT INTO `ormSimple_lang` (`id`, `lang_id`, `title`) VALUES (1, 1, "title1_1"), (1, 2, "title1_2"), (2, 1, "title2_1"), (3, 2, "title3_2")');
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormSimple_lang`');
    }

    public function setUp()
    {
        $this->mapper = new ormSimpleI18nMapper();
        $this->mapper->attach(new i18nPlugin(array('title')), 'i18n');

        systemConfig::$i18n = 'ru';

        $this->setLang(1);
    }

    public function tearDown()
    {
        $this->cleardb();

        systemConfig::$i18n = $this->default_locale;
    }

    public function testRetrieve()
    {
        $this->fixture();

        $object = $this->mapper->searchByKey(1);
        $this->assertEqual($object->getTitle(), 'title1_1');

        $this->setLang(2);

        $object = $this->mapper->searchByKey(1);
        $this->assertEqual($object->getTitle(), 'title1_2');

        $object = $this->mapper->searchByKey(2);
        $this->assertNull($object);
    }

    private function setLang($id)
    {
        static $toolkit;

        if (!$toolkit) {
            $toolkit = systemToolkit::getInstance();
        }

        $toolkit->setLang($id);
        $this->mapper->plugin('i18n')->resetLangId();
    }
}

?>