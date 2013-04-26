<?php

fileLoader::load('service/sha1PasswordHash');


class sha1PasswordHashTest extends unitTestCase
{
    protected $service;

    function setUp()
    {
        $this->service = new sha1PasswordHash();
    }

    public function tearDown()
    {
    }

    public function testApplyHash()
    {
        $string = 'string_for_hash';

        // f6b1cf538e25cc16a5b59e36687218ed210fa2a2 - hash of 'string_for_hash'
        $this->assertEqual($this->service->apply($string), 'f6b1cf538e25cc16a5b59e36687218ed210fa2a2');
    }
}

?>