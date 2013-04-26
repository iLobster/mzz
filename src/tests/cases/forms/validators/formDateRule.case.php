<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formDateRule');

class formDateRuleTest extends UnitTestCase
{
    public function testMatch()
    {
        $rule = new formDateRule();
        $this->assertTrue($rule->validate(array('month' => 11, 'day' => 5, 'year' => 2008)));
    }

    public function testMatchString()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->validate('+1 month'));
        $this->assertTrue($rule->validate('21.11.2008'));
        $this->assertTrue($rule->validate('2008/11/11'));
    }

    public function testMatchRegex()
    {
        // элементы даты переставлены специально чтобы проверить валидацию именно по рег. выражению
        $regex = '#^(?<day>\d{2})-(?<year>\d{4})-(?<month>\d{2})$#';
        $rule = new formDateRule('', array('regex' => $regex));
        $this->assertTrue($rule->validate('15-2008-11'));
        $regex = '#^(?<day>\d{2})-(?<year>\d{4})-(?<month>\d{2}) (?<minute>\d{2}):(?<hour>\d{2})$#';
        $rule = new formDateRule('', array('regex' => $regex));
        $this->assertTrue($rule->validate('15-2008-11 58:05'));
    }

    public function testEmpty()
    {
        $rule = new formDateRule();
        $this->assertTrue($rule->validate(array('month' => 0, 'day' => 0, 'year' => 0)));
        $this->assertFalse($rule->validate(array('month' => 0, 'day' => 1, 'year' => 0)));

        $time = array('month' => 0, 'day' => 0, 'year' => 0, 'hour' => 12, 'minute' => 50, 'second' => 30);
        $this->assertTrue($rule->validate($time));
    }

    public function testNotMatch()
    {
        $rule = new formDateRule();
        $this->assertFalse($rule->validate(array('month' => 14, 'day' => 5, 'year' => 2008)));
        $this->assertFalse($rule->validate(array('month' => 11, 'day' => 32, 'year' => 2008)));
        $this->assertFalse($rule->validate(array('month' => 'a', 'day' => 15, 'year' => 2008)));
        $date = array('month' => 11, 'day' => 12, 'year' => 2008, 'hour' => 25, 'minute' => 5, 'second' => 6);
        $this->assertFalse($rule->validate($date));
    }


    public function testMatchWithTime()
    {
        $rule = new formDateRule();
        $date = array('month' => 11, 'day' => 5, 'year' => 2008, 'hour' => 12, 'minutes' => 15, 'seconds' => 30);
        $this->assertTrue($rule->validate($date));
    }

    public function testMatchStringWithTime()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->validate('2008/11/11 12:59:59'));
        $this->assertTrue($rule->validate('12:59:59 2008/11/11'));
    }

    public function testMatchOldTime()
    {
        $rule = new formDateRule();
        $this->assertFalse($rule->validate('1960/11/11')); // strtotime doesn't understand it
        $this->assertTrue($rule->validate(array('year' => 1960, 'month' => 11, 'day' => 11)));
    }

    public function testNotMatchStringWithTime()
    {
        $rule = new formDateRule('date', '');
        $this->assertFalse($rule->validate('2008/11/11 12:59:61'));
        $this->assertFalse($rule->validate('2008/11/11 12'));
    }

    public function testMinMax()
    {
        $params = array('min' => strtotime('10 october 2008'), 'max' => strtotime('2 January 2009'));
        $rule = new formDateRule('', $params);
        $this->assertTrue($rule->validate('2008/12/11'));
        $this->assertTrue($rule->validate('2009/01/01'));
        $this->assertFalse($rule->validate('2009/01/03'));
        $this->assertFalse($rule->validate('2008/01/03'));

        $this->assertTrue($rule->validate('10 october 2008'));
        $this->assertTrue($rule->validate('2 January 2009'));
    }
}

?>