<?php

fileLoader::load('service/userPreferences');


class userPreferencesTest extends unitTestCase
{
    protected $service;

    function setUp()
    {
        $this->service = new userPreferences();
        $this->service->clear();
        $this->session = systemToolkit::getInstance()->getSession();
    }

    public function tearDown()
    {
        $this->service->clear();
    }

    public function testEmpty()
    {
        $this->assertNull($this->service->getSkin());
        $this->assertNull($this->service->getLang());
        $this->assertNull($this->service->getTimezone());
        $this->assertNull($this->service->getDefaultTimezone());
    }

    public function testSetGetSkin()
    {
        $this->service->setSkin($value = 'simple');
        $this->assertEqual($this->service->getSkin(), $value);
    }


    public function testSetGetLang()
    {
        $this->service->setLang($value = 'ru');
        $this->assertEqual($this->service->getLang(), $value);
    }

    public function testSetGetTimezone()
    {
        $this->service->setTimezone($value = 'Europe');
        $this->assertEqual($this->service->getTimezone(), $value);
    }

    public function testSetGetDefaultTimezone()
    {
        $this->service->setDefaultTimezone($value = 'UTC');
        $this->assertEqual($this->service->getDefaultTimezone(), $value);
    }
}

?>