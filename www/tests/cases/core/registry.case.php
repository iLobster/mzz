<?php
fileLoader::load('core/registry');

class firstStubClass {
   public $b = 'tested';
}

class secondStubClass extends firstStubClass {}

class registryTest extends unitTestCase
{
    private $registry;
    public function setUp()
    {
        $this->registry = Registry::instance();
        $this->registry->save();
    }

    public function tearDown()
    {
        $this->registry->restore();
    }

    public function testRegistry()
    {
        $foo = new firstStubClass;
        $this->registry->setEntry('foo', $foo);
        $this->assertEqual($this->registry->getEntry('foo'), $foo);
        $this->registry->save();
        $this->assertFalse($this->registry->isEntry('foo'));
        $bar = new firstStubClass;
        $this->registry->setEntry('foo', $bar);
        $this->assertReference($this->registry->getEntry('foo'), $bar);
        $this->registry->restore();
        $this->assertReference($this->registry->getEntry('foo'), $foo);

        $this->registry->setEntry('second', 'secondStubClass');
        $this->assertEqual($this->registry->getEntry('second')->b, 'tested');

    }

}

?>