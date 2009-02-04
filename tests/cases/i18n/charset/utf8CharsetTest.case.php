<?php

fileLoader::load('i18n/charset/utf8Charset');
fileLoader::load('cases/i18n/charset/utf8CharsetTest');

class utf8BaseCharsetTest extends utf8CharsetTest
{
    protected $driver;
    public function setUp()
    {
        $this->driver = new utf8Charset();
    }
}