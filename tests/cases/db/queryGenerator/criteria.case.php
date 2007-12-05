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

        $this->assertEqual($this->criteria->getTable(), $table);
    }

    public function testSetTableAlias()
    {
        $this->criteria->setTable($table = 'sometable', $alias = 'somealias');

        $this->assertEqual($this->criteria->getTable(), array('table' => $table, 'alias' => $alias));
    }

    public function testAddAndRemoveKeys()
    {
        $this->criteria->add('field', 'value')->add('field2', 'value2');
        $criterion = new criterion('field3', 'value3');
        $this->criteria->add($criterion)->add(new criterion())->add(new criterion());
        $this->assertEqual($this->criteria->keys(), array('field', 'field2', 'field3', 0, 1));
        $this->criteria->remove('field')->remove('field3');
        $this->assertEqual($this->criteria->keys(), array('field2', 0, 1));
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
        $this->assertEqual($this->criteria->getOrderByFields(), array('field', 'field2'));
        $this->assertEqual($this->criteria->getOrderBySettings(), array(array('alias' => true, 'direction' => 'ASC'), array('alias' => true, 'direction' => 'DESC')));
    }

    public function testAddOrderByFunction()
    {
        $this->criteria->setOrderByFieldAsc($function = new sqlFunction('rand'));
        $this->assertEqual($this->criteria->getOrderByFields(), array($function));
        $this->assertEqual($this->criteria->getOrderBySettings(), array(array('alias' => true, 'direction' => 'ASC')));
    }

    public function testGetSetLimitAndOffset()
    {
        $this->criteria->setLimit($limit = 20);
        $this->assertEqual($this->criteria->getLimit(), $limit);

        $this->criteria->setOffset($offset = 40);
        $this->assertEqual($this->criteria->getOffset(), $offset);
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
        $joins = $this->criteria->getJoins();
        $this->assertEqual(count($joins), 1);

        $this->assertEqual($joins[0]['table'], $table);
        $this->assertReference($joins[0]['criterion'], $criterion);
    }

    public function testAppendData()
    {
        $newCriteria = new criteria();
        $newCriteria->setLimit($limit = 5)->setOffset($offset = 17);

        $this->criteria->append($newCriteria);

        $this->assertEqual($this->criteria->getLimit(), $limit);
        $this->assertEqual($this->criteria->getOffset(), $offset);
    }

    public function testDistinct()
    {
        $this->assertFalse($this->criteria->getDistinct());
        $this->criteria->setDistinct();
        $this->assertTrue($this->criteria->getDistinct());
        $this->criteria->setDistinct(false);
        $this->assertFalse($this->criteria->getDistinct());
    }

    public function testCriterionWithFunction()
    {
        $criterion = new criterion(new sqlFunction('foo', array(2, 3)), 'bar');
        $this->criteria->add($criterion);
        $this->assertEqual($this->criteria->getCriterion('foo_2_3'), $criterion);
    }
}

?>