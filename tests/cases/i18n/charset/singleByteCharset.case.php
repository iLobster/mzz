<?php

fileLoader::load('i18n/charset/singleByteCharset');

class singleByteCharsetTest extends UnitTestCase
{
    protected $driver;
    public function setUp()
    {
        $this->driver = new singleByteCharset();
    }

    public function testCallWithSubstr()
    {
        $this->assertEqual($this->driver->substr("test foo", 1), "est foo");
        $this->assertEqual($this->driver->substr("test foo", 0, 5), "test ");
    }
}