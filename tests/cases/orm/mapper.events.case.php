<?php

fileLoader::load('orm/mapper');
fileLoader::load('orm/plugins/versionablePlugin');
fileLoader::load('orm/plugins/softDeletePlugin');
fileLoader::load('cases/orm/ormSimple');

class stubObserver extends observer
{
    private $methods = array();

    public function __call($name, $value)
    {
        $this->methods[] = $name;
    }

    public function getStack()
    {
        return $this->methods;
    }

    public function pop()
    {
        return array_pop($this->methods);
    }

    public function clear()
    {
        $this->methods = array();
    }
}

class inverseObserverPlugin extends observer
{
    public function preInsert(& $data)
    {
        foreach ($data as &$value) {
            if (is_string($value)) {
                $value = strrev($value);
            }
        }
    }

    public function preUpdate(& $data)
    {
        if (is_array($data)) {
            foreach ($data as $key => & $value) {
                if (is_string($value)) {
                    $value = new sqlFunction('reverse', $key, true);
                }
            }
        }
    }
}

class mapperEventsTest extends unitTestCase
{
    private $mapper;
    private $db;
    private $fixture;

    public function __construct()
    {
        $this->db = fDB::factory();
        $this->cleardb();

        $this->fixture = array(
            1 => array(
                'foo' => 'foo1',
                'bar' => 'bar1'),
            2 => array(
                'foo' => 'foo2',
                'bar' => 'bar2'),
            3 => array(
                'foo' => 'foo3',
                'bar' => 'bar3'));
    }

    public function setUp()
    {
        $this->mapper = new ormSimpleMapper();
    }

    public function tearDown()
    {
        $this->cleardb();
    }

    private function fixture()
    {
        $valString = '';
        foreach ($this->fixture as $id => $data) {
            $valString .= "(" . $id . ", '" . $data['foo'] . "', '" . $data['bar'] . "'), ";
        }
        $valString = substr($valString, 0, -2);

        $this->db->query('INSERT INTO `ormSimple` (`id`, `foo`, `bar`) VALUES ' . $valString);
    }

    public function cleardb()
    {
        $this->db->query('TRUNCATE TABLE `ormSimple`');
        $this->db->query('TRUNCATE TABLE `ormSimple_version`');
    }

    public function testPluginAttach()
    {
        $observer = new inverseObserverPlugin();
        $attachName = 'myInvertseObserverName';
        $this->mapper->attach($observer, $attachName);

        $this->assertEqual($observer, $this->mapper->plugin($attachName));
    }

    public function testPluginDetach()
    {
        $observer = new inverseObserverPlugin();
        $this->mapper->attach($observer);

        $this->assertEqual($observer, $this->mapper->plugin('inverseObserver'));

        $this->mapper->detach('inverseObserver');

        try {
            $this->mapper->plugin('inverseObserver');
        } catch (mzzRuntimeException $e) {
            $this->assertPattern('/The specified.*inverseObserver.*plugin doesn\'t attached to current mapper/', $e->getMessage());
            $this->pass();
        } catch (Exception $e) {
            $this->fail('Брошено не ожидаемое исключение');
        }
    }


    public function testPluginAttachWithoutName()
    {
        $observer = new inverseObserverPlugin();
        $this->mapper->attach($observer);

        $this->assertEqual($observer, $this->mapper->plugin('inverseObserver'));
    }

    public function testSampleObserver()
    {
        $observer = new inverseObserverPlugin();
        $this->mapper->attach($observer);

        $object = $this->mapper->create();

        $object->setFoo('new');

        $this->assertNull($object->getFoo());

        $this->mapper->save($object);

        $this->assertEqual($object->getFoo(), 'wen');

        $object->setFoo('wen');
        $this->mapper->save($object);

        $this->assertEqual($object->getFoo(), 'new');
    }

    public function testSoftDelete()
    {
        $this->fixture();
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple`'), 3);

        $this->mapper->plugins('softDelete');

        $object = $this->mapper->searchByKey(2);

        $this->assertEqual($object->getFoo(), 'foo2');

        $this->mapper->delete($object);

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple`'), 3);

        $object = $this->mapper->searchByKey(2);
        $this->assertNull($object);
    }

    public function testVersionable()
    {
        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple_version`'), 0);

        $this->mapper->plugins('versionable');

        $object = $this->mapper->create();
        $object->setFoo('new');

        $this->mapper->save($object);
        $this->assertEqual($object->getVersion(), 1);

        $object->setFoo('changed');
        $this->mapper->save($object);

        $this->assertEqual($object->getVersion(), 2);

        $this->mapper->plugin('versionable')->revert($object, 1);

        $this->assertEqual($object->getVersion(), 1);
        $this->assertEqual($object->getFoo(), 'new');

        $this->mapper->plugin('versionable')->revert($object, 2);

        $this->assertEqual($object->getVersion(), 2);
        $this->assertEqual($object->getFoo(), 'changed');

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple_version`'), 2);

        $this->mapper->delete($object);

        $this->assertEqual($this->db->getOne('SELECT COUNT(*) FROM `ormSimple_version`'), 0);
    }
}

?>