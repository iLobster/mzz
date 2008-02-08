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
        $bbcode_parser = new bbcode('[i]test[/i]');
        $this->assertEqual('<em>test</em>', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[b][i]test[/i][/b][u][i]test[/i][/u]');
        $this->assertEqual('<strong><em>test</em></strong><span style="text-decoration: underline;"><em>test</em></span>', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithAttributes()
    {
        $bbcode_parser = new bbcode('[quote=zerkms]test[/quote]');
        $this->assertEqual('<span>quote:"zerkms" - test</span>', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[color="red"]test[/color]');
        $this->assertEqual('<font color="red">test</font>', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[size="+1"]test[/size]');
        $this->assertEqual('<font size="+1">test</font>', $bbcode_parser->parse());
    }

    public function testParseBBCodeWithWrongAttributes()
    {
        $bbcode_parser = new bbcode('[font not_exist="+1"]test[/font]');
        $this->assertEqual('[font not_exist="+1"]test[/font]', $bbcode_parser->parse());

        $bbcode_parser = new bbcode('[color]test[/color]');
        $this->assertEqual('[color]test[/color]', $bbcode_parser->parse());
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