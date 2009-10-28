<?php

fileLoader::load('forms/validators/formValidator');

class formValidatorTest extends UnitTestCase
{
    /**
     * @var newFormValidator
     */
    protected $validator;

    /**
     * @var httpRequest
     */
    protected $request;

    public function __construct()
    {
        $this->request = systemToolkit::getInstance()->getRequest();
    }

    public function setUp()
    {
        $this->request->save();
        $this->validator = new formValidator();
    }

    public function tearDown()
    {
        $this->request->restore();
    }

    public function testNotValidateWithNoSubmit()
    {
        $this->assertFalse($this->validator->validate());
    }

    public function testValidate()
    {
        $this->validator->setData(array('data' => 'value', 'submit' => true));

        $this->validator->rule('required', 'data');

        $this->assertTrue($this->validator->validate());
    }

    public function testValidateError()
    {
        $this->validator->setData(array('data' => 'value', 'submit' => true));

        $this->validator->rule('required', 'data');
        $this->validator->rule('required', $field = 'data5', $errorMsg = 'Some error message');
        $this->assertFalse($this->validator->validate());
        $errors = $this->validator->getErrors();
        $this->assertEqual($errors[$field], $errorMsg);
    }

    public function testValidateFromRequest()
    {
        $_POST = array();
        $_POST['data'] = 'foo';
        $_POST['array']['nested'] = 'bar';
        $_POST['submit'] = 'true';
        $this->request->refresh();

        $this->validator->rule('required', 'data');
        $this->validator->rule('required', 'array[nested]');
        $this->assertTrue($this->validator->validate());
    }

/*
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
/*
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
    } */
}

?>