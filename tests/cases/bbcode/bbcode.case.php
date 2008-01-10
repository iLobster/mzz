<?php

fileLoader::load('bbcode');

class bbcodeTest extends unitTestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testParseBBCode()
    {
        $bbcode_parser = new bbcode('[b]test[/b]');
        $this->assertEqual('<strong>test</strong>', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithAttributes()
    {
        $bbcode_parser = new bbcode('[img src="http://ya.ru/logo.gif"]test[/img]');
        $this->assertEqual('<img src="http://ya.ru/logo.gif">test</img>', $bbcode_parser->parse());
    }
}
?>