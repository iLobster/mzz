<?php

fileLoader::load('service/userPreferences');


class userPreferencesTest extends unitTestCase
{
    protected $service;

    function setUp()
    {
        $this->service = new userPreferences();
        $this->session = systemToolkit::getInstance()->getSession();
    }

    public function tearDown()
    {
        $this->session->destroy(userPreferences::$langVarName);
        $this->session->destroy(userPreferences::$tzVarName);
        $this->session->destroy(userPreferences::$tzDefaultVarName);
        $this->session->destroy(userPreferences::$skinVarName);
    }

    public function testSetGetSkin()
    {
        $this->session->set(userPreferences::$skinVarName, $value = 'simple');
        $this->assertEqual($this->service->getSkin(), 'simple');
    }

    public function testSetGetLang()
    {
        $this->session->set(userPreferences::$langVarName, $value = 'ru');
        $this->assertEqual($this->service->getLang(), 'ru');
    }

    public function testSetGetTimezone()
    {
        $this->session->set(userPreferences::$tzVarName, $value = 'Europe');
        $this->assertEqual($this->service->getTimezone(), 'Europe');
    }

    public function testSetGetDefaultTimezone()
    {
        $this->session->set(userPreferences::$tzDefaultVarName, $value = 'UTC');
        $this->assertEqual($this->service->getDefaultTimezone(), 'UTC');
    }
}

?>