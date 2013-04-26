<?php

fileLoader::load('i18n/charset/utf8MbstringCharset');
fileLoader::load('cases/i18n/charset/utf8CharsetTest');

class utf8MbstringCharsetTest extends utf8CharsetTest
{
    protected $driver;
    public function setUp()
    {
        $this->driver = new utf8MbstringCharset();
    }

    public function skip()
    {
        $this->skipIf(!extension_loaded('mbstring'), 'Mbstring extension not found. Test skipped.');
    }
}