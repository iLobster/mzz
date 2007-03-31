<?php
fileLoader::load('forms/validate/validators/formDigitsValidator');

class formDigitsValidatorTest extends UnitTestCase
{
    protected $validator;

    public function setup()
    {
        $this->validator = new formDigitsValidator();
    }

    function teardown()
    {
    }

    public function testValidator()
	{
		$good = array('', '0', '15155', '-1', '52525156', '-63636636', '00001');
		$bad = array('0.33', 'aab00', '+1', '-', '--1', '!@$');

		foreach ($good as $value) {
			$this->assertTrue($this->validator->isValid($value), "Правильное значение: " . $value);
		}

		foreach ($bad as $value) {
			$this->assertFalse($this->validator->isValid($value), "Неправильное значение: " . $value);
		}

	}

}
?>