<?php
fileLoader::load('db/criteria');

class criteriaTest extends unitTestCase
{
    private $criteria;

    public function setUp()
    {
        $this->criteria = new criteria();
    }

    public function testSetTable()
    {
        $this->criteria->setTable($table = 'sometable');

        $this->assertTrue($this->criteria->getTable(), $table);
    }

    public function testAddAndKeys()
    {
        $this->criteria->add('field', 'value');
        $this->criteria->add('field2', 'value2');
        $criterion = new criterion('field3', 'value3');
        $this->criteria->add($criterion);
        $this->criteria->add(new criterion());
        $this->criteria->add(new criterion());
        $this->assertEqual($this->criteria->keys(), array('field', 'field2', 'field3', 0, 1));
    }

    public function testOverwriteKeys()
    {
        $this->criteria->add('field', 'value');
        $this->criteria->add('field', 'value2');
        $this->assertEqual($this->criteria->keys(), array('field'));
    }

    public function testGetCriterion()
    {
        $this->criteria->add('field', 'value');
        $this->assertEqual($this->criteria->getCriterion('field'), new criterion('field', 'value'));
    }
}

?>