<?php
fileLoader::load('forms/formElement');

class stubFormElement extends formElement
{
    static public function toString($options = array()) {}
}

class formElementTest extends UnitTestCase
{
    function setup()
    {
    }

    function teardown()
    {
    }

    function testCreateTag()
    {
        $options = array('type' => 'text', 'name' => 'title', 'id' => 'id_title', 'value' => 'someValue', 'class' => 'element');
        $expected = "<input class=\"element\" id=\"id_title\" name=\"title\" type=\"text\" value=\"someValue\" />";
        $this->assertEqual(stubFormElement::createTag($options), $expected);
    }

    function testCreateContentTag()
    {
        $options = array('name' => 'body', 'id' => 'id_body', 'class' => 'text', 'content' => 'someContent');
        $expected = "<textarea class=\"text\" id=\"id_body\" name=\"body\">someContent</textarea>";
        $this->assertEqual(stubFormElement::createTag($options, 'textarea'), $expected);
    }

    function testCreateDisabledTag()
    {
        $options = array('type' => 'text', 'name' => 'title', 'id' => 'id_title', 'value' => 'someValue', 'disabled' => true);
        $expected = "<input disabled=\"disabled\" id=\"id_title\" name=\"title\" type=\"text\" value=\"someValue\" />";
        $this->assertEqual(stubFormElement::createTag($options), $expected);
    }

    function testEscapeValues()
    {
        $options = array('type' => 'text', 'name' => 'title', 'id' => 'id_title', 'value' => '"<>&amp;');
        $expected = "<input id=\"id_title\" name=\"title\" type=\"text\" value=\"&quot;&lt;&gt;&amp;\" />";
        $this->assertEqual(stubFormElement::createTag($options), $expected);
    }
}

?>