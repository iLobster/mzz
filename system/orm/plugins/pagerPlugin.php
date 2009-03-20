<?php
fileLoader::load('pager/pager');
class pagerPlugin extends observer
{
    const OBSERVER_NAME = 'pager';

    protected $pager;

    public function __construct(pager $pager)
    {
        $this->pager = $pager;
        parent::__construct();
    }

    public function preSqlSelect(criteria $criteria)
    {
        $criteriaForCount = clone $criteria;
        $criteriaForCount->clearSelectFields()->addSelectField(new sqlFunction('count', new sqlOperator('DISTINCT', $this->mapper->table() . '.' . $this->mapper->pk())), 'cnt');
        $selectForCount = new simpleSelect($criteriaForCount);

        $this->pager->setCount($this->mapper->db()->getOne($selectForCount->toString()));

        $criteria->append($this->pager->getLimitQuery());

        $this->mapper->detach(self::OBSERVER_NAME);
    }
}

?>