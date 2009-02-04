<?php

abstract class utf8CharsetTest extends UnitTestCase
{
    protected $driver = null;

    public function testSubstr()
    {
        $this->assertEqual($this->driver->substr("тест", 2), "ст");
        $this->assertEqual($this->driver->substr("Ŕœñø", 0, 5), "Ŕœñø");
        $this->assertEqual($this->driver->substr("Ŕœñø", 1, 2), "œñ");
        $this->assertEqual($this->driver->substr("Ŕœñø", 0, -1), "Ŕœñ");

    }

    public function testRtrim()
    {
        $this->assertEqual($this->driver->rtrim("\nŔœñø\r\n"), "\nŔœñø");
        $this->assertEqual($this->driver->rtrim("ŔœñøŔ", "Ŕ"), "Ŕœñø");
    }

    public function testLtrim()
    {
        $this->assertEqual($this->driver->ltrim("\nŔœñø\r\n"), "Ŕœñø\r\n");
        $this->assertEqual($this->driver->ltrim("ŔœñøŔ", "Ŕ"), "œñøŔ");
    }

    public function testTrim()
    {
        $this->assertEqual($this->driver->trim("\nŔœñø\r\n"), "Ŕœñø");
        $this->assertEqual($this->driver->trim("ŔœñøŔ", "Ŕ"), "œñø");
        $this->assertEqual($this->driver->trim("стестс ", "с "), "тест");
    }

    public function testStrReplace()
    {
        $this->assertEqual($this->driver->str_replace("е", "ё", "пчелка"), "пчёлка");
        $search = array("Ŕ", "е");
        $replace = array("п", "ё");
        $this->assertEqual($this->driver->str_replace($search, $replace, "Ŕчелка"), "пчёлка");
    }

    public function testStrlen()
    {
        $this->assertEqual($this->driver->strlen("âôë"), 3);
        $this->assertEqual($this->driver->strlen("ётест"), 5);
    }

    public function testStrpos()
    {
        $this->assertEqual($this->driver->strpos("хёлло", "ёл"), 1);
        $this->assertEqual($this->driver->strpos("хёлло", "л", 3), 3);
    }

    public function testStrrpos()
    {
        $this->assertEqual($this->driver->strrpos("хёлло", "ёл"), 1);
        $this->assertEqual($this->driver->strrpos("хёлло", "л"), 3);
        $this->assertEqual($this->driver->strrpos("хёлло", "л", 3), 3);
        $this->assertEqual($this->driver->strrpos("хёлло", "ё", 1), 1);
        $this->assertEqual($this->driver->strrpos("хёлло", "ё", 2), false);
    }

    public function testStrtolower()
    {
        $this->assertEqual($this->driver->strtolower("прИвЕт МалЕНькие БУКВЫ"), "привет маленькие буквы");
    }

    public function testStrtoupper()
    {
        $this->assertEqual($this->driver->strtoupper("привет Большие буквы"), "ПРИВЕТ БОЛЬШИЕ БУКВЫ");
    }

    public function testUcfirst()
    {
        $this->assertEqual($this->driver->ucfirst("тест"), "Тест");
        $this->assertEqual($this->driver->ucfirst("Тест"), "Тест");
        $this->assertEqual($this->driver->ucfirst(" тест"), " тест");
    }


    public function testSubstrCount()
    {
        $str = "тест.foo.ёё тест текст";
        $this->assertEqual($this->driver->substr_count($str, "тест"), 2);
    }

    public function testStrcasecmp()
    {
        $this->assertEqual($this->driver->strcasecmp("тест", "тест"), 0);
        $this->assertEqual($this->driver->strcasecmp("тест", "ТесТ"), 0);
        $this->assertTrue($this->driver->strcasecmp("тест", "ТЕСТЫ") < 0);
        $this->assertTrue($this->driver->strcasecmp("тесты", "ТЕСТ") > 0);
    }


    public function testStrSplit()
    {
        $this->assertEqual($this->driver->str_split('Ёётекст'), array('Ё','ё','т','е','к','с','т'));
        $this->assertEqual($this->driver->str_split('Ёётекст', 2), array('Ёё','те','кс','т'));
    }

    public function testStrSplitNewline()
    {
        $str = "Iñtërn\nâtiônàl\nizætiøn\n";
        $array = array(
        'I','ñ','t','ë','r','n',"\n",'â','t','i','ô','n','à','l',"\n",'i',
        'z','æ','t','i','ø','n',"\n",
        );
        $this->assertEqual($this->driver->str_split($str), $array);
    }
}