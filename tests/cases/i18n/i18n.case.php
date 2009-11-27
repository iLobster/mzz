<?php

fileLoader::load('service/userPreferences');
fileLoader::load('i18n');

class i18nTest extends UnitTestCase
{
    private $i18n;

    private $tz;

    private $old_tz = '';

    public function setUp()
    {
        $this->i18n = new i18n();
        systemToolkit::getInstance()->setI18n($this->i18n);

        $this->tz = systemToolkit::getInstance()->getUserPreferences()->getTimezone();

        systemToolkit::getInstance()->getUserPreferences()->setTimezone(0);

        $default_tz = "Europe/Moscow";
        if (version_compare(PHP_VERSION, '5.2.0', '>')) {
            $this->old_tz = date_default_timezone_get();
            date_default_timezone_set($default_tz);
        } else {
            if (getenv('TZ')) {
                $this->old_tz = getenv('TZ');
            }
            putenv('TZ=' . $default_tz);
        }
    }

    public function tearDown()
    {
        systemToolkit::getInstance()->getUserPreferences()->setTimezone($this->tz);
        if ($this->old_tz && version_compare(PHP_VERSION, '5.2.0', '>')) {
            date_default_timezone_set($this->old_tz);
        } elseif ($this->old_tz) {
            putenv('TZ=' . $this->old_tz);
        }
        systemToolkit::getInstance()->setI18n(null);
    }

    private function injectPhrases($phrases)
    {
        foreach ($phrases as $module => $module_data) {
            foreach ($module_data as $lang => $data) {
                $this->i18n->setPhrases($module, $lang, $data);
            }
        }
    }

    public function testSimple()
    {
        $this->injectPhrases(array(

        'module' => array('en' => array('t1' => 'translate1', 't2' => 'translate2')),

        'module2' => array(
        'en' => array('t3' => 'translate3', 't4' => 'translate4'),
        'ru' => array('t3' => 'translate_russian_3', 't4' => 'translate_russian_4'),
        )

        )
        );

        $this->assertEqual($this->i18n->translate('t1', 'module', 'en'), 'translate1');
        $this->assertEqual($this->i18n->translate('t3', 'module2', 'en'), 'translate3');
        $this->assertEqual($this->i18n->translate('t3', 'module2', 'ru'), 'translate_russian_3');
    }

    public function testNonExists()
    {
        $this->injectPhrases(array(
        'module' => array('en' => array('t1' => 'translate1', 't2' => 'translate2')),
        )
        );

        $this->assertEqual($this->i18n->translate('t1', 'module', 'ru'), 'translate1');
        $this->assertEqual($this->i18n->translate('not_exists', 'module3', 'jp'), 'not_exists');
    }

    public function testUnnamedPlaceholders()
    {
        $this->injectPhrases(array('module3' => array('en' => array('foo' => 'foo ? bar ? ?'))));

        $this->assertEqual($this->i18n->translate('foo', 'module3', 'en', 'baz lol'), 'foo baz bar lol ?');
        $this->assertEqual($this->i18n->translate('foo', 'module3', 'en', '1 2 3 4'), 'foo 1 bar 2 3');
    }

    public function testNamedPlaceholders()
    {
        $this->injectPhrases(array('module4' => array('en' => array('foo' => ':3 foo :1 bar :2'))));

        $this->assertEqual($this->i18n->translate('foo', 'module4', 'en', 'a b c d'), 'c foo a bar b');
        $this->assertEqual($this->i18n->translate('foo', 'module4', 'en', 'a b'), ':3 foo a bar b');
    }

    public function testTranslateVariablePlaceholders()
    {
        $this->injectPhrases(array('module5' => array('en' => array('foo' => '? foo ? bar ?'))));
        $this->assertEqual($this->i18n->translate('foo', 'module5', 'en', '$a c $b', array($this, 'stub_callback')), '? foo c bar ?-a, b');

        $this->injectPhrases(array('module6' => array('en' => array('foo' => ':2 foo :1 bar :3'))));
        $this->assertEqual($this->i18n->translate('foo', 'module6', 'en', '$a b $c', array($this, 'stub_callback')), 'b foo :1 bar :3-a, c');
    }

    public function testNoMorphForms()
    {
        $morph = 'word';
        $this->assertEqual($this->i18n->morph(1, $morph, 'ru'), $morph);
        $this->assertEqual($this->i18n->morph(2, $morph, 'ru'), $morph);
        $this->assertEqual($this->i18n->morph(5, $morph, 'ru'), $morph);
    }

    public function testMorph()
    {
        $morphs = array('слово', 'слова', 'слов');
        $this->assertEqual($this->i18n->morph(1, $morphs, 'ru'), $morphs[0]);
        $this->assertEqual($this->i18n->morph(2, $morphs, 'ru'), $morphs[1]);
        $this->assertEqual($this->i18n->morph(5, $morphs, 'ru'), $morphs[2]);
    }

    public function stub_callback($phrase, $variables)
    {
        return $phrase . '-' . implode(', ', $variables);
    }


    public function testDate()
    {
        $time = strtotime('2008-03-12 06:24:05');
        $this->assertEqual(i18n::date($time), '03/12/2008 03:24:05 AM');
        $this->assertEqual(i18n::date($time, 'short_time'), '03:24 AM');
        $this->assertEqual(i18n::date($time, 'short_time', 'ru'), '03:24');
    }

    public function testGetMessage()
    {
        $this->injectPhrases(array(
        'module' => array('en' => array('t1' => 'translate1', 't2' => 'translate2'))
        ));

        $this->assertEqual(i18n::getMessage('t1', 'module', 'en'), 'translate1');
        $this->assertEqual(i18n::getMessage('foo/t1', null, 'en'), 'foo/t1');
        $this->assertEqual(i18n::getMessage('module/t1', null, 'en'), 'translate1');
    }
}

?>