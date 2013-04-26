<?php

fileLoader::load('i18n/charset/utf8IconvCharset');
fileLoader::load('cases/i18n/charset/utf8CharsetTest');

class utf8IconvCharsetTest extends utf8CharsetTest
{
    protected $driver;
    public function setUp()
    {
        $this->driver = new utf8IconvCharset();
    }

    public function skip()
    {
        $this->skipIf(!extension_loaded('iconv'), 'Iconv extension not found. Test skipped.');
    }
}