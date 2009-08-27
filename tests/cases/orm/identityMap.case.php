<?php

fileLoader::load('orm/identityMap');

class imTestMapper extends mapper
{
    protected $class = 'imTest';
}

class imTest extends entity
{

}

mock::generate('imTestMapper');

class identityMapTest extends unitTestCase
{
    /**
     * @var identityMap
     */
    private $im;
    /**
     * @var mapper
     */
    private $mock;

    public function setUp()
    {
        $this->mock = new mockimTestMapper();
        $this->im = new identityMap($this->mock);
    }

    public function testSetGet()
    {
        $this->mock->setReturnValue('map', array());
        $this->mock->setReturnValue('create', $obj = new imTest($this->mock));

        $object = $this->mock->create();

        $this->assertTrue($object === $obj);
        $this->im->set($id = 666, $object);
        $this->assertTrue($object === $this->im->get($id));
    }

    public function testDelay()
    {
        $ids = array(
            1,
            3,
            7);

        $this->mock->expectOnce('searchByKey', array(
            $ids));

        $this->im->delay($ids[0]);
        $this->im->delay($ids[1]);
        $this->im->delay($ids[2]);

        $this->im->get(1);
    }
}

?>