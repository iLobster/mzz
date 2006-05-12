<?php

fileLoader::load('service/md5PasswordHash');


class md5PasswordHashTest extends unitTestCase
{
    protected $service;

    function setUp()
    {
        $this->service = new md5PasswordHash();
    }

    public function tearDown()
    {
    }

    public function testApplyHash()
    {
        $string = 'string_for_hash';

        // 9df62c8b7241febabd68ac62ee52c002 - hash of 'string_for_hash'
        $this->assertEqual($this->service->apply($string), '9df62c8b7241febabd68ac62ee52c002');
    }
}

?>