<?php

fileLoader::load('forms/validators/formValidator');

class formValidatorTest extends UnitTestCase
{
    protected $validator;
    protected $request;

    public function setup()
    {
        $this->validator = new formValidator();

        $this->request = systemToolkit::getInstance()->getRequest();
        $this->request->save();
    }

    function teardown()
    {
        $this->request->restore();
    }

    public function testValidate()
    {
        $_POST['data'] = 'value';
        $_POST['data2'] = 'value';
        $_POST['data3'] = 'value';
        $this->request->refresh();

        $this->validator->add('required', 'data');
        $this->validator->add('required', 'data2');
        $this->validator->add('required', 'data3');
        $this->assertTrue($this->validator->validate());
    }

    public function testValidateError()
    {
        $_POST['data'] = 'value';
        $this->request->refresh();

        $this->validator->add('required', 'data');
        $this->validator->add('required', $field = 'data5', $errorMsg = 'Some error message');
        $this->assertFalse($this->validator->validate());
        $errors = $this->validator->getErrors();
        $this->assertEqual($errors->get($field), $errorMsg);
    }
}

?>