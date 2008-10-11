<?php

fileLoader::load('forms/validators/formValidator');

class formValidatorTest extends UnitTestCase
{
    protected $validator;
    protected $request;

    public function setup()
    {
        $this->validator = new formValidator();
        $this->validator->disableCSRF();

        $this->request = systemToolkit::getInstance()->getRequest();
        $this->request->save();
    }

    function teardown()
    {
        $this->request->restore();
    }

    public function testNotValidateWithNoSubmit()
    {
        $validator = new formValidator();
        $this->assertFalse($validator->validate());
    }

    public function testValidate()
    {
        $_POST['submit'] = 'submit';
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
        $_POST['submit'] = 'submit';
        $_POST['data'] = 'value';
        $this->request->refresh();

        $this->validator->add('required', 'data');
        $this->validator->add('required', $field = 'data5', $errorMsg = 'Some error message');
        $this->assertFalse($this->validator->validate());
        $errors = $this->validator->getErrors();
        $this->assertEqual($errors->get($field), $errorMsg);
    }

    public function testValidateFromArg()
    {
        $data = array('foo'=> true);

        $this->validator->add('required', 'foo');
        $this->validator->add('required', 'bar', $errorMsg = 'Some error message');

        $this->assertFalse($this->validator->validate($data));
        $errors = $this->validator->getErrors();
        $this->assertEqual($errors->get('bar'), $errorMsg);

        $data['bar'] = 10;
        $this->validator->add('numeric', 'bar');
        $this->assertTrue($this->validator->validate($data));
    }

    /**
     * @todo move to formCsrfRuleTest?
     *
     */
    public function testValidateCSRF()
    {
        $this->validator->enableCSRF();
        $_POST['submit'] = 'submit';
        $_POST['data'] = 'value';
        systemToolkit::getInstance()->getSession()->set('CSRFToken', $key = 'secret_token');
        $this->assertFalse($this->validator->validate());
        $_POST[form::$CSRFField] = $key;
        $this->assertTrue($this->validator->validate());
        systemToolkit::getInstance()->getSession()->destroy('CSRFToken');
    }
}

?>