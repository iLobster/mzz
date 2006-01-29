<?php

fileLoader::load('news');

class newsTest extends unitTestCase
{
    public function testAccessorsAndMutators()
    {
        $news = new news();
        $props = array('Title', 'Text', 'FolderId');
        foreach ($props as $prop) {
            $getprop = 'get' . $prop;
            $setprop = 'set' . $prop;

            $this->assertNull($news->$getprop());

            $val = 'foo';
            $news->$setprop($val);

            $this->assertEqual($val, $news->$getprop());

            $val2 = 'bar';
            $news->$setprop($val2);

            $this->assertEqual($val2, $news->$getprop());
            $this->assertNotEqual($val, $news->$getprop());
        }
    }

    public function testException()
    {
        $news = new news();

        try {
            $news->getFoo();
            $this->fail('������ ���� ������ EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/news::getfoo/i', $e->getMessage());
        }

        try {
            $news->setFoo();
            $this->fail('������ ���� ������ EXCEPTION!');
        } catch (Exception $e) {
            $this->assertWantedPattern('/news::setfoo/i', $e->getMessage());
        }
    }
}

?>