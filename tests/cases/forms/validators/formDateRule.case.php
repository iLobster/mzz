<?php

fileLoader::load('forms/validators/formAbstractRule');
fileLoader::load('forms/validators/formDateRule');

class formDateRuleTest extends UnitTestCase
{
    public function setup()
    {
    }

    function teardown()
    {
    }

    public function testMatch()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->setValue(array('month' => 11, 'day' => 5, 'year' => 2008))->validate());
    }

    public function testMatchString()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->setValue('+1 month')->validate());
        $this->assertTrue($rule->setValue('21.11.2008')->validate());
        $this->assertTrue($rule->setValue('2008/11/11')->validate());
    }

    /*public function testInteger()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->setValue(time())->validate());
        $this->assertTrue($rule->setValue(0)->validate());
        $this->assertFalse($rule->setValue(-1)->validate());
    }*/

    public function testMatchRegex()
    {
        // элементы даты переставлены специально чтобы проверить валидацию именно по рег. выражению
        $regex = '#^(?<day>\d{2})-(?<year>\d{4})-(?<month>\d{2})$#';
        $rule = new formDateRule('date', '', array('regex' => $regex));
        $this->assertTrue($rule->setValue('15-2008-11')->validate());
        $regex = '#^(?<day>\d{2})-(?<year>\d{4})-(?<month>\d{2}) (?<minute>\d{2}):(?<hour>\d{2})$#';
        $rule = new formDateRule('date', '', array('regex' => $regex));
        $this->assertTrue($rule->setValue('15-2008-11 58:05')->validate());
    }

    public function testEmpty()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->setValue(array('month' => 0, 'day' => 0, 'year' => 0))->validate());
        $this->assertFalse($rule->setValue(array('month' => 0, 'day' => 1, 'year' => 0))->validate());

        $time = array('month' => 0, 'day' => 0, 'year' => 0, 'hour' => 12, 'minute' => 50, 'second' => 30);
        $this->assertTrue($rule->setValue($time)->validate());
    }

    public function testNotMatch()
    {
        $rule = new formDateRule('date', '');
        $this->assertFalse($rule->setValue(array('month' => 14, 'day' => 5, 'year' => 2008))->validate());
        $this->assertFalse($rule->setValue(array('month' => 11, 'day' => 32, 'year' => 2008))->validate());
        $this->assertFalse($rule->setValue(array('month' => 'a', 'day' => 15, 'year' => 2008))->validate());
        $date = array('month' => 11, 'day' => 12, 'year' => 2008, 'hour' => 25, 'minute' => 5, 'second' => 6);
        $this->assertFalse($rule->setValue($date)->validate());
    }


    public function testMatchWithTime()
    {
        $rule = new formDateRule('date', '');
        $date = array('month' => 11, 'day' => 5, 'year' => 2008, 'hour' => 12, 'minutes' => 15, 'seconds' => 30);
        $this->assertTrue($rule->setValue($date)->validate());
    }

    public function testMatchStringWithTime()
    {
        $rule = new formDateRule('date', '');
        $this->assertTrue($rule->setValue('2008/11/11 12:59:59')->validate());
        $this->assertTrue($rule->setValue('12:59:59 2008/11/11')->validate());
    }

    public function testMatchOldTime()
    {
        $rule = new formDateRule('date', '');
        $this->assertFalse($rule->setValue('1960/11/11')->validate()); // strtotime doesn't understand it
        $this->assertTrue($rule->setValue(array('year' => 1960, 'month' => 11, 'day' => 11))->validate());
    }

    public function testNotMatchStringWithTime()
    {
        $rule = new formDateRule('date', '');
        $this->assertFalse($rule->setValue('2008/11/11 12:59:61')->validate());
        $this->assertFalse($rule->setValue('2008/11/11 12')->validate());
    }

    public function testMinMax()
    {
        $params = array('min' => strtotime('10 october 2008'), 'max' => strtotime('2 January 2009'));
        $rule = new formDateRule('date', '', $params);
        $this->assertTrue($rule->setValue('2008/12/11')->validate());
        $this->assertTrue($rule->setValue('2009/01/01')->validate());
        $this->assertFalse($rule->setValue('2009/01/03')->validate());
        $this->assertFalse($rule->setValue('2008/01/03')->validate());

        $this->assertTrue($rule->setValue('10 october 2008')->validate());
        $this->assertTrue($rule->setValue('2 January 2009')->validate());
    }
}

?>