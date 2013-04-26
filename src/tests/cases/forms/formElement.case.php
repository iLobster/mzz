<?php
fileLoader::load('forms/formElement');

class stubFormElement extends formElement
{
    public function render($attributes = array(), $value = null) {}
}

class formElementTest extends UnitTestCase
{
    protected $element;

    public function setup()
    {
        $this->element = new stubFormElement();
    }

    public function teardown()
    {
    }

    public function testSetGetAttribute()
    {
        $this->element->setAttribute($key = 'test', $val = 'value');
        $this->assertEqual($this->element->getAttribute($key), $val);
    }

    public function testSetGetFormat()
    {
        $this->element->setAttribute('idFormat', $val = 'test_id_format');
        $this->assertEqual($this->element->getIdFormat(), $val);
    }

    public function testIsFreeze()
    {
        $this->assertEqual($this->element->isFreeze(array('freeze' => $val = false)), $val);
        $this->assertEqual($this->element->isFreeze(array('freeze' => $val = true)), $val);
    }

    public function testAttributesToHtml()
    {
        $this->element->addOptions(array('option_field'));
        $attributes = array(
        'type' => 'text',
        'name' => 'title',
        'id' => 'id_title',
        'disabled' => true,
        'value' => '',
        'checked' => true,
        'some_null_field' => null,
        'some_false_field' => false,
        'option_field' => 'str1',
        'readonly' => false
        );
        $expected = ' type="text" name="title" id="id_title" disabled="disabled" value="" checked="checked"';
        $this->assertEqual($this->element->attributesToHtml($attributes), $expected);
    }

    public function testRenderTag()
    {
        $attributes = array(
        'type' => 'text',
        'name' => 'title',
        'id' => 'id_title',
        'disabled' => true,
        'value' => ''
        );
        $expected = '<input disabled="disabled" id="id_title" name="title" type="text" value="" />';
        $this->assertEqual($this->element->renderTag('input', $attributes), $expected);

        $attributes = array(
        'name' => 'title',
        'id' => 'id_title',
        'content' => 'test'
        );
        $expected = '<textarea id="id_title" name="title">test</textarea>';
        $this->assertEqual($this->element->renderTag('textarea', $attributes), $expected);
    }

    public function testRenderFormTag()
    {
        $attributes = array('name' => 'title', 'id' => 'id_title');
        $expected = '<form id="id_title" name="title">';
        $this->assertEqual($this->element->renderTag('form', $attributes), $expected);
    }

    public function testRenderFreeze()
    {
        $attributes = array(
        'type' => 'text',
        'name' => 'title',
        'id' => 'id_title',
        'disabled' => true,
        'value' => 'test1',
        'freeze' => true
        );
        $expected = 'test1';
        $this->assertEqual($this->element->renderTag('input', $attributes), $expected);

        $attributes = array(
        'name' => 'title',
        'id' => 'id_title',
        'content' => 'test2',
        'freeze' => true
        );
        $expected = 'test2';
        $this->assertEqual($this->element->renderTag('textarea', $attributes), $expected);
    }

    public function testGenerateId()
    {
        $this->assertEqual($this->element->generateId('name[][][a][bcef]', 'test_%s'), 'test_name_a_bcef');
        $this->assertEqual($this->element->generateId('name[][a][bcef]', 'test_%s', 2), 'test_name_2_a_bcef');
    }

    public function testGetValue()
    {
        $request = systemToolkit::getInstance()->getRequest();
        $_POST['val_str'] = $str = 'string';
        $_POST['val_arr'] = $arr = array('elm1', array('elm2'), 'elm3');
        $request->refresh();

        $this->assertEqual($this->element->getElementValue(array('name' => 'val_str')), $str);
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_arr[]')), $arr[0]);
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_arr[]'), false, true), $arr);
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_arr[1][]')), $arr[1][0]);
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_arr[2]')), $arr[2]);
        $this->assertEqual($this->element->getElementValue(array('name' => 'nonexists'), 'def'), 'def');
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_arr')), $arr);
        $this->assertEqual($this->element->getElementValue(array('name' => 'val_str', 'value' => $permanentValue = 'thisispermanentstring', 'useDefault' => true)), $permanentValue);

        $request->save();
        $request->restore();
    }

    public function testEscapeValues()
    {
        $attributes = array('type' => 'text', 'id' => 'test', 'name' => 'title', 'value' => '"<>&amp;');
        $expected = '<input id="test" name="title" type="text" value="&quot;&lt;&gt;&amp;" />';
        $this->assertEqual($this->element->renderTag('input', $attributes), $expected);
    }

    public function testNameRequired()
    {
        $attributes = array('type' => 'text', 'id' => 'test');
        try {
            $this->element->toString($attributes);
            $this->fail("Name isn't specified but exception didn't thrown");
        } catch (mzzRuntimeException $e) {
            $this->pass();
        }

    }
}

?>