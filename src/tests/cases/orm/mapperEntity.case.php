<?php

fileLoader::load('orm/abstractMapper');
fileLoader::load('orm/mapperEntity');

class stubEntityMapper extends abstractMapper
{
    protected $map = array(
        'id' => array(
            'accessor' => 'getId',
            'mutator' => 'setId',
            'options' => array('pk', 'once')
        )
    );
}

class mapperEntityTest extends unitTestCase
{
    private $entity;

    public function setUp()
    {
        $mapper = new stubEntityMapper(null);
        $this->entity = new mapperEntity($mapper);
    }

    public function testImportExportMerge()
    {
        $data = array(
            'id' => 1);

        $this->entity->import($data);
        $this->assertEqual($this->entity->export(), $data);

        $this->entity->merge($new = array(
            'id' => 666));
        $this->assertEqual($this->entity->export(), $new);
    }

    public function testUnknownMethod()
    {
        try {
            $this->entity->getUnknown();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/entity::getUnknown/i', $e->getMessage());
        }
    }

    public function testAccessor()
    {
        $data = array(
            'id' => 1);
        $this->entity->import($data);

        $this->assertEqual($this->entity->getId(), $data['id']);
    }

    /*
    public function testSetGetState()
    {
        $this->assertEqual($this->entity->state(), entity::STATE_NEW);

        $this->entity->state(entity::STATE_DIRTY);

        $this->assertEqual($this->entity->state(), entity::STATE_DIRTY);
    }

    public function testMutator()
    {
        $this->assertEqual($this->entity->state(), entity::STATE_NEW);
        $this->entity->setId(2);
        $this->assertEqual($this->entity->state(), entity::STATE_NEW);
        $this->assertEqual($this->entity->exportChanged(), array(
            'id' => 2));
    }
    */

    public function testEmptyMutator()
    {
        try {
            $this->entity->setId();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/entity::setId.*one argument/i', $e->getMessage());
        }
    }

    public function testRO()
    {
        $mapper = new stubMapperRO(null);
        $entity = new entity($mapper);

        try {
            $entity->setId(666);
            $this->fail('exception expected');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/setId.*read only/i', $e->getMessage());
        }
    }
}

?>