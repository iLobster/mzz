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
        $this->criteria->add('field', 'value')->add('field2', 'value2');
        $criterion = new criterion('field3', 'value3');
        $this->criteria->add($criterion)->add(new criterion())->add(new criterion());
        $this->assertEqual($this->criteria->keys(), array('field', 'field2', 'field3', 0, 1));
    }

    public function testOverwriteKeys()
    {
        $this->criteria->add('field', 'value')->add('field', 'value2');
        $this->assertEqual($this->criteria->keys(), array('field'));
    }

    public function testGetCriterion()
    {
        $this->criteria->add('field', 'value');
        $criterion = new criterion('field', 'value');
        $this->assertEqual($this->criteria->getCriterion('field')->getField(), $criterion->getField());
        $this->assertEqual($this->criteria->getCriterion('field')->getValue(), $criterion->getValue());
    }

    public function testAddOrderBy()
    {
        $this->criteria->setOrderByFieldAsc('field')->setOrderByFieldDesc('field2');
        $this->assertEqual($this->criteria->getOrderByFields(), array('`field` ASC', '`field2` DESC'));
    }

    public function testGetSetLimitAndOffset()
    {
        $this->criteria->setLimit($limit = 20);
        $this->assertEqual($this->criteria->getLimit(), $limit);

        $this->criteria->setOffset($offset = 40);
        $this->assertEqual($this->criteria->getOffset(), $offset);
    }

    public function testEnableCount()
    {
        $this->assertFalse($this->criteria->getEnableCount());
        $this->criteria->enableCount();
        $this->assertTrue($this->criteria->getEnableCount());
    }

    public function testSelectFields()
    {
        $this->assertEqual($this->criteria->getSelectFields(), array());
        $this->criteria->addSelectField('field', 'alias');
        $this->assertEqual($this->criteria->getSelectFields(), array('field'));
        $this->assertEqual($this->criteria->getSelectFieldAlias('field'), 'alias');
        $this->criteria->clearSelectFields();
        $this->assertEqual($this->criteria->getSelectFields(), array());
    }

    public function testJoin()
    {
        $this->assertEqual($this->criteria->getJoins(), array());
        $this->criteria->addJoin($table = 'foo', $criterion = new criterion());
        $this->assertEqual($this->criteria->getJoins(), array(0 => array('table' => '`' . $table . '`', 'criterion' => $criterion)));
    }
}

?>