<?php

fileLoader::load('orm/entity');

class entityTest extends unitTestCase
{
    private $entity;

    public function setUp()
    {
        $this->entity = new entity();
    }

    public function fixture()
    {
        $map = array(
            'id' => array(
                'accessor' => 'getId',
                'mutator' => 'setId'));
        $this->entity->setMap($map);
    }

    public function testSetGetMap()
    {
        $map = array(
            'id' => array(
                'accessor' => 'getId',
                'mutator' => 'setId'));

        $this->entity->setMap($map);
        $this->assertEqual($this->entity->getMap(), $map);
    }

    public function testImportExportMerge()
    {
        $data = array(
            'id' => 1);

        $map = array(
            'id' => array(
                'accessor' => 'getId',
                'mutator' => 'setId'));

        $this->entity->setMap($map);

        $this->entity->import($data);
        $this->assertEqual($this->entity->export(), $data);

        $this->entity->merge($new = array(
            'id' => 666));
        $this->assertEqual($this->entity->export(), $new);
    }

    public function testUnknownMethod()
    {
        $this->fixture();

        try {
            $this->entity->getUnknown();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/entity::getUnknown/i', $e->getMessage());
        }
    }

    public function testAccessor()
    {
        $this->fixture();

        $data = array(
            'id' => 1);
        $this->entity->import($data);

        $this->assertEqual($this->entity->getId(), $data['id']);
    }

    public function testSetGetState()
    {
        $this->assertEqual($this->entity->state(), entity::STATE_NEW);

        $this->entity->state(entity::STATE_DIRTY);

        $this->assertEqual($this->entity->state(), entity::STATE_DIRTY);
    }

    public function testMutator()
    {
        $this->fixture();

        $this->assertEqual($this->entity->state(), entity::STATE_NEW);
        $this->entity->setId(2);
        $this->assertEqual($this->entity->state(), entity::STATE_NEW);
        $this->assertEqual($this->entity->exportChanged(), array(
            'id' => 2));
    }

    public function testEmptyMutator()
    {
        $this->fixture();

        try {
            $this->entity->setId();
            $this->fail();
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/entity::setId.*one argument/i', $e->getMessage());
        }
    }

    public function testRO()
    {
        $map = array(
            'id' => array(
                'accessor' => 'getId',
                'mutator' => 'setId',
                'options' => array(
                    'ro')));

        $this->entity->setMap($map);

        try {
            $this->entity->setId(666);
            $this->fail('exception expected');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/setId.*read only/i', $e->getMessage());
        }
    }
}

?>