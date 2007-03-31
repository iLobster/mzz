<?php
fileLoader::load('forms/validate/formValidate');

class stubFormValidator
{
    public function isValid($value) {}
}
Mock::generate("stubFormValidator");

class formValidateTest extends UnitTestCase
{
    protected $validate;

    public function setup()
    {
        $this->validate = new formValidate();
    }

    function teardown()
    {
    }

    public function testAddValidator()
    {
        $value = "text";
        $validator = new mockstubFormValidator;
        $validator->expectOnce('isValid', array($value));
        $this->validate->addValidator($validator);
        $this->validate->validate($value);
    }

    public function testValid()
    {
        $value = "text";
        $firstValidator = new mockstubFormValidator;
        $secondValidator = new mockstubFormValidator;

        $firstValidator->expectOnce('isValid', array($value));
        $firstValidator->setReturnValue('isValid', true);

        $secondValidator->expectOnce('isValid', array($value));
        $secondValidator->setReturnValue('isValid', true);


        $this->validate->addValidator($firstValidator);
        $this->validate->addValidator($secondValidator);

        $this->assertTrue($this->validate->validate($value), 'Значение должно быть валидным');
    }

    public function tesNotValid()
    {
        $value = "text";
        $firstValidator = new mockstubFormValidator;
        $secondValidator = new mockstubFormValidator;

        $firstValidator->expectOnce('isValid', array($value));
        $firstValidator->setReturnValue('isValid', true);

        $secondValidator->expectOnce('isValid', array($value));
        $secondValidator->setReturnValue('isValid', false);


        $this->validate->addValidator($firstValidator);
        $this->validate->addValidator($secondValidator);

        $this->assertFalse($this->validate->validate($value), 'Значение должно быть невалидным');
    }

    public function testBreakValidation()
    {
        $value = "text";
        $firstValidator = new mockstubFormValidator;
        $secondValidator = new mockstubFormValidator;
        $thirdValidator = new mockstubFormValidator;

        $firstValidator->expectOnce('isValid', array($value));
        $firstValidator->setReturnValue('isValid', true);

        $secondValidator->expectOnce('isValid', array($value));
        $secondValidator->setReturnValue('isValid', false);

        $thirdValidator->expectNever('isValid');

        // так же проверим что проверка не прерывается если строка валидная для первого валидатора
        $this->validate->addValidator($firstValidator, true);
        $this->validate->addValidator($secondValidator, true);
        $this->validate->addValidator($thirdValidator);

        $this->assertFalse($this->validate->validate($value), 'Значение должно быть невалидным');
    }

}
?>