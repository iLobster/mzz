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

        $bbcode_parser = new bbcode('[batr="test"]test[/b]');
        $this->assertEqual('[batr="test"]test[/b]', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[i]test[/i]');
        $this->assertEqual('<em>test</em>', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithAttributes()
    {
        $bbcode_parser = new bbcode('[font size="+1"]test[/font]');
        $this->assertEqual('<font size="+1">test</font>', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[font size="+1" font-family="Verdana"]test[/font]');
        $this->assertEqual('<font size="+1" font-family="Verdana">test</font>', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[font font-family="Verdana" size="+1"]test[/font]');
        $this->assertEqual('<font font-family="Verdana" size="+1">test</font>', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithWrongAttributes()
    {
        $bbcode_parser = new bbcode('[font not_exist="+1"]test[/font]');
        $this->assertEqual('[font not_exist="+1"]test[/font]', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithWrongAttributesValues()
    {
        $bbcode_parser = new bbcode('[font size="+999"]test[/font]');
        $this->assertEqual('[font size="+999"]test[/font]', $bbcode_parser->parse());
    }

    public function testParseBBCodeUnclosed()
    {
        $bbcode_parser = new bbcode('[b]test[/b');
        $this->assertEqual('[b]test[/b', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('test[/b]');
        $this->assertEqual('test[/b]', $bbcode_parser->parse());
    }
}
?>