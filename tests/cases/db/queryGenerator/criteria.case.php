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
        $this->criteria->table($table = 'sometable');

        $this->assertEqual($this->criteria->getTable(), $table);
    }

    public function testSetTableAlias()
    {
        $this->criteria->table($table = 'sometable', $alias = 'somealias');

        $this->assertEqual($this->criteria->getTable(), array('table' => $table, 'alias' => $alias));
    }

    public function testAddAndRemoveKeys()
    {
        $this->criteria->where('field', 'value')->where('field2', 'value2');
        $criterion = new criterion('field3', 'value3');
        $this->criteria->where($criterion)->where(new criterion())->where(new criterion());
        $this->assertEqual($this->criteria->keys(), array('field', 'field2', 'field3', 0, 1));
        $this->criteria->remove('field')->remove('field3');
        $this->assertEqual($this->criteria->keys(), array('field2', 0, 1));
    }

    public function testAddHaving()
    {
        $this->criteria->having('field', 'value')->having(new sqlFunction('count', '*', true), 10, criteria::GREATER);
        $having = $this->criteria->getHaving();
        $this->assertEqual(2, sizeof($having));
        $this->assertTrue(isset($having['count_*']));
        $this->assertTrue(isset($having['field']));
    }

    public function testOverwriteKeys()
    {
        $this->criteria->where('field', 'value')->where('field', 'value2');
        $this->assertEqual($this->criteria->keys(), array('field'));
    }

    public function testGetCriterion()
    {
        $this->criteria->where('field', 'value');
        $criterion = new criterion('field', 'value');
        $this->assertEqual($this->criteria->getCriterion('field')->getField(), $criterion->getField());
        $this->assertEqual($this->criteria->getCriterion('field')->getValue(), $criterion->getValue());
    }

    public function testAddOrderBy()
    {
        $this->criteria->orderByAsc('field')->orderByDesc('field2');
        $this->assertEqual($this->criteria->getOrderByFields(), array('field', 'field2'));
        $this->assertEqual($this->criteria->getOrderBySettings(), array(array('alias' => true, 'direction' => 'ASC'), array('alias' => true, 'direction' => 'DESC')));
    }

    public function testAddOrderByFunction()
    {
        $this->criteria->orderByAsc($function = new sqlFunction('rand'));
        $this->assertEqual($this->criteria->getOrderByFields(), array($function));
        $this->assertEqual($this->criteria->getOrderBySettings(), array(array('alias' => true, 'direction' => 'ASC')));
    }

    public function testGetSetLimitAndOffset()
    {
        $this->criteria->limit($limit = 20);
        $this->assertEqual($this->criteria->getLimit(), $limit);

        $this->criteria->offset($offset = 40);
        $this->assertEqual($this->criteria->getOffset(), $offset);
    }

    public function testSelectFields()
    {
        $this->assertEqual($this->criteria->getSelectFields(), array());
        $this->criteria->select('field', 'alias');
        $this->assertEqual($this->criteria->getSelectFields(), array('field'));
        $this->assertEqual($this->criteria->getSelectFieldAlias('field'), 'alias');
        $this->criteria->clearSelect();
        $this->assertEqual($this->criteria->getSelectFields(), array());
    }

    public function testJoin()
    {
        $this->assertEqual($this->criteria->getJoins(), array());
        $this->criteria->join($table = 'foo', $criterion = new criterion());
        $joins = $this->criteria->getJoins();
        $this->assertEqual(count($joins), 1);

        $this->assertEqual($joins[0]['table'], $table);
        $this->assertReference($joins[0]['criterion'], $criterion);
    }

    public function testAppendData()
    {
        $newCriteria = new criteria();
        $newCriteria->limit($limit = 5)->offset($offset = 17);

        $this->criteria->append($newCriteria);

        $this->assertEqual($this->criteria->getLimit(), $limit);
        $this->assertEqual($this->criteria->getOffset(), $offset);
    }

    public function testAppendWithFromSubquery()
    {
        $newCriteria = new criteria('table2');
        $newCriteria->where('q', 2);
        $this->criteria->table($newCriteria, 'alias');

        $this->criteria->where('a', 3);

        $c2 = new criteria('table', 'alias');
        $c2->append($this->criteria);

        $this->assertEqual($c2->debug(true), 'SELECT * FROM (SELECT * FROM `table2` WHERE `table2`.`q` = 2) `alias` WHERE `alias`.`a` = 3');
    }

    public function testDistinct()
    {
        $this->assertFalse($this->criteria->getDistinct());
        $this->criteria->distinct();
        $this->assertTrue($this->criteria->getDistinct());
        $this->criteria->distinct(false);
        $this->assertFalse($this->criteria->getDistinct());
    }

    public function testCriterionWithFunction()
    {
        $criterion = new criterion(new sqlFunction('foo', array(2, 3)), 'bar');
        $this->criteria->where($criterion);
        $this->assertEqual($this->criteria->getCriterion('foo_2_3'), $criterion);
    }
}

?>